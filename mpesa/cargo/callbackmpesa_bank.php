<?php
// callback.php - Daraja STK Push Callback Handler + IntaSend Disbursement
// Updated January 2026 - PesaBridge Project

require_once 'config.php';
require_once 'db.php';

// Read raw POST data from Safaricom (JSON)
$json = file_get_contents('php://input');
$callback = json_decode($json, true);

// Always log the full callback for debugging & audit
file_put_contents('logs/callbacks.log', date('Y-m-d H:i:s') . " - " . $json . PHP_EOL, FILE_APPEND);

// Safaricom sends empty/invalid callbacks sometimes - early exit if no useful data
if (!isset($callback['Body']['stkCallback'])) {
    http_response_code(200);
    echo "Accepted";
    exit;
}

if (isset($callback['Body']['stkCallback']['ResultCode'])) {
    $resultCode   = $callback['Body']['stkCallback']['ResultCode'];
    $merchantID   = $callback['Body']['stkCallback']['MerchantRequestID'];
    $resultDesc   = $callback['Body']['stkCallback']['ResultDesc'] ?? 'No description';

    if ($resultCode == 0) {
        // Payment collected successfully
        // Extract M-Pesa Receipt Number from metadata (Item[1] is usually the receipt)
        $receipt = '';
        if (isset($callback['Body']['stkCallback']['CallbackMetadata']['Item'])) {
            foreach ($callback['Body']['stkCallback']['CallbackMetadata']['Item'] as $item) {
                if ($item['Name'] === 'MpesaReceiptNumber') {
                    $receipt = $item['Value'] ?? '';
                    break;
                }
            }
        }

        // Update transaction status to collected
        $stmt = $pdo->prepare("
            UPDATE cargo_pay_mpesa_bank 
            SET status = 'collected', 
                mpesa_receipt = ?, 
                collected_at = NOW() 
            WHERE merchant_request_id = ?
        ");
        $stmt->execute([$receipt, $merchantID]);

        // Fetch full transaction details to trigger disbursement
        $txStmt = $pdo->prepare("SELECT * FROM cargo_pay_mpesa_bank WHERE merchant_request_id = ?");
        $txStmt->execute([$merchantID]);
        $tx = $txStmt->fetch(PDO::FETCH_ASSOC);

        if ($tx) {
            disburseToBank($tx['id'], $tx['amount'], $tx['recipient_bank_code'], $tx['recipient_account'], $tx['recipient_name']);
        } else {
            // Rare case: transaction not found in DB
            file_put_contents('logs/callbacks.log', date('Y-m-d H:i:s') . " - WARNING: Transaction not found for MerchantRequestID $merchantID" . PHP_EOL, FILE_APPEND);
        }
    } else {
        // Payment failed (user cancelled, insufficient funds, etc.)
        $reason = $resultDesc ?: 'Unknown failure';
        $stmt = $pdo->prepare("
            UPDATE cargo_pay_mpesa_bank 
            SET status = 'failed', 
                failed_reason = ? 
            WHERE merchant_request_id = ?
        ");
        $stmt->execute([$reason, $merchantID]);

        logEvent($merchantID, 'stkpush_failed', "STK Push failed: $reason");
    }
}

http_response_code(200);
echo "Success";

// ────────────────────────────────────────────────────────────────────────────────
// Disbursement Function (PesaLink via IntaSend - robust version 2026)
function disburseToBank($tx_id, $amount, $bank_code, $account, $name) {
    global $pdo;

    $url = 'https://sandbox.intasend.com/api/v1/payment/payouts/'; 
    // Switch to live when ready: 'https://api.intasend.com/api/v1/payment/payouts/'

    $payload = [
        'api_key'     => INTASEND_API_KEY,
        'currency'    => 'KES',
        'amount'      => $amount,
        'method'      => 'pesalink',  // Explicitly request PesaLink for bank transfer
        'beneficiary' => [
            'bank_code'     => $bank_code,      // e.g., '02' for Equity
            'account_number' => $account,
            'account_name'  => $name
        ],
        'narration'   => "MPAY TX #$tx_id - Transfer to bank"
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);           // Prevent long hangs
    $res = curl_exec($ch);

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    $response = json_decode($res, true);

    // Success handling
    if ($httpCode >= 200 && $httpCode < 300 && isset($response['status']) && strtolower($response['status']) === 'success') {
        $ref = $response['reference'] ?? $response['tracking_id'] ?? $response['id'] ?? 'No ref';

        $stmt = $pdo->prepare("
            UPDATE cargo_pay_mpesa_bank 
            SET status = 'disbursed', 
                pesalink_reference = ?, 
                disbursed_at = NOW() 
            WHERE id = ?
        ");
        $stmt->execute([$ref, $tx_id]);

        logEvent($tx_id, 'disbursement_success', "Disbursed successfully. Ref: $ref");
        return true;
    }

    // Failure handling - detailed logging
    $failure_reason = "Disbursement failed. HTTP $httpCode";
    if ($curlError) {
        $failure_reason .= " | cURL error: $curlError";
    }
    if (is_array($response)) {
        $failure_reason .= " | " . ($response['message'] ?? $response['error'] ?? $response['detail'] ?? 'Unknown error');
        if (isset($response['code'])) {
            $failure_reason .= " (Code: {$response['code']})";
        }
    } else if ($res) {
        $failure_reason .= " | Raw response: " . substr($res, 0, 500);
    } else {
        $failure_reason .= " | No response received";
    }

    // Mark transaction as failed
    $stmt = $pdo->prepare("
        UPDATE cargo_pay_mpesa_bank 
        SET status = 'failed', 
            failed_reason = ? 
        WHERE id = ?
    ");
    $stmt->execute([$failure_reason, $tx_id]);

    // Audit log
    logEvent($tx_id, 'disbursement_failed', $failure_reason);

    // Optional: Critical alert (uncomment in production)
    // mail('admin@pesabridge.com', "Disbursement Failure TX#$tx_id", $failure_reason);

    return false;
}

// Helper: Audit logging to cargo_pay_mpesa_bank_tranx_logs table
function logEvent($transaction_id, $event, $details) {
    global $pdo;

    // If transaction_id is MerchantRequestID (string), convert or adjust as needed
    // For simplicity we assume it's compatible or cast to string in DB

    $stmt = $pdo->prepare("
        INSERT INTO cargo_pay_mpesa_bank_tranx_logs (transaction_id, event, details)
        VALUES (?, ?, ?)
    ");
    $stmt->execute([$transaction_id, $event, $details]);
}
?>
