<?php
// callback.php
// Daraja STK Push Callback Handler + IntaSend PesaLink Disbursement
// Updated for CargoPay - Table: cargo_pay_mpesa_bank
// Changes: account_name → bank_name in payload, recipient_name → recipient_bank_name
// Last updated: January 15, 2026

require_once 'config.php';
require_once '../../DB_connection.php';

// ────────────────────────────────────────────────────────────────────────────────
// Read raw POST data from Safaricom
$json = file_get_contents('php://input');
$callback = json_decode($json, true);

// Always log the incoming callback - very important for debugging
$log_time = date('Y-m-d H:i:s');
file_put_contents('logs/callbacks.log', $log_time . " - " . $json . PHP_EOL, FILE_APPEND);

// Early exit if not a valid STK callback structure
if (!isset($callback['Body']['stkCallback'])) {
    http_response_code(200);
    echo "Accepted (empty callback)";
    exit;
}

// ────────────────────────────────────────────────────────────────────────────────
// Process STK Push result
if (isset($callback['Body']['stkCallback']['ResultCode'])) {
    $resultCode   = $callback['Body']['stkCallback']['ResultCode'];
    $merchantID   = $callback['Body']['stkCallback']['MerchantRequestID'];
    $resultDesc   = $callback['Body']['stkCallback']['ResultDesc'] ?? 'No description provided';

    if ($resultCode == 0) {
        // ─── SUCCESS: Payment collected ───────────────────────────────────────

        // Extract M-Pesa Receipt Number from CallbackMetadata (reliable way)
        $receipt = '';
        if (isset($callback['Body']['stkCallback']['CallbackMetadata']['Item'])) {
            foreach ($callback['Body']['stkCallback']['CallbackMetadata']['Item'] as $item) {
                if ($item['Name'] === 'MpesaReceiptNumber') {
                    $receipt = $item['Value'] ?? '';
                    break;
                }
            }
        }

        // Update transaction to collected
        $stmt = $pdo->prepare("
            UPDATE cargo_pay_mpesa_bank 
            SET 
                status = 'collected',
                mpesa_receipt = ?,
                collected_at = NOW()
            WHERE merchant_request_id = ?
        ");
        $stmt->execute([$receipt, $merchantID]);

        // Fetch transaction details to proceed with disbursement
        $txStmt = $pdo->prepare("
            SELECT id, user_id, amount, recipient_bank_code, recipient_account, recipient_bank_name 
            FROM cargo_pay_mpesa_bank 
            WHERE merchant_request_id = ?
        ");
        $txStmt->execute([$merchantID]);
        $tx = $txStmt->fetch(PDO::FETCH_ASSOC);

        if ($tx) {
            disburseToBank(
                $tx['id'],
                $tx['user_id'],
                $tx['amount'],
                $tx['recipient_bank_code'],
                $tx['recipient_account'],
                $tx['recipient_bank_name']  // Now using the renamed column
            );
        } else {
            file_put_contents(
                'logs/callbacks.log',
                $log_time . " - CRITICAL: Transaction not found for MerchantRequestID: $merchantID\n",
                FILE_APPEND
            );
        }
    } else {
        // ─── FAILURE: STK Push failed ──────────────────────────────────────────
        $reason = $resultDesc ?: 'Unknown failure';

        $stmt = $pdo->prepare("
            UPDATE cargo_pay_mpesa_bank 
            SET 
                status = 'failed',
                failed_reason = ? 
            WHERE merchant_request_id = ?
        ");
        $stmt->execute([$reason, $merchantID]);

        logEvent($merchantID, 'stkpush_failed', "STK Push failed: $reason");
    }
}

// Always respond with 200 OK to Safaricom
http_response_code(200);
echo "Success";

// ────────────────────────────────────────────────────────────────────────────────
// Function: Send money to bank via IntaSend (PesaLink)
function disburseToBank($tx_id, $user_id, $amount, $bank_code, $account, $bank_name) {
    global $pdo;

    $url = 'https://sandbox.intasend.com/api/v1/payment/payouts/';
    // LIVE: 'https://api.intasend.com/api/v1/payment/payouts/'

    $payload = [
        'api_key'     => INTASEND_API_KEY,
        'currency'    => 'KES',
        'amount'      => $amount,
        'method'      => 'pesalink',
        'beneficiary' => [
            'bank_code'      => $bank_code,
            'account_number' => $account,
            'bank_name'      => $bank_name   // ← Changed from account_name to bank_name
        ],
        'narration'   => "CargoPay TX #$tx_id - Transfer to bank"
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    $res = curl_exec($ch);

    $httpCode   = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError  = curl_error($ch);
    curl_close($ch);

    $response = json_decode($res, true);

    // ─── SUCCESS CASE ────────────────────────────────────────────────────────
    if ($httpCode >= 200 && $httpCode < 300 && isset($response['status']) && strtolower($response['status']) === 'success') {
        $ref = $response['reference'] ?? $response['tracking_id'] ?? $response['id'] ?? 'No reference';

        $stmt = $pdo->prepare("
            UPDATE cargo_pay_mpesa_bank 
            SET 
                status = 'disbursed',
                pesalink_reference = ?,
                disbursed_at = NOW()
            WHERE id = ?
        ");
        $stmt->execute([$ref, $tx_id]);

        logEvent($tx_id, 'disbursement_success', "Disbursed successfully. Ref: $ref");

        // Update user stats
        updateUserStats($user_id, $amount);

        return true;
    }

    // ─── FAILURE CASE ────────────────────────────────────────────────────────
    $failure_reason = "Disbursement failed. HTTP $httpCode";
    if ($curlError) {
        $failure_reason .= " | cURL error: $curlError";
    }
    if (is_array($response)) {
        $msg = $response['message'] ?? $response['error'] ?? $response['detail'] ?? 'Unknown error';
        $failure_reason .= " | $msg";
        if (isset($response['code'])) {
            $failure_reason .= " (Code: {$response['code']})";
        }
    } elseif ($res) {
        $failure_reason .= " | Raw response: " . substr($res, 0, 500);
    } else {
        $failure_reason .= " | No response received";
    }

    $stmt = $pdo->prepare("
        UPDATE cargo_pay_mpesa_bank 
        SET 
            status = 'failed',
            failed_reason = ? 
        WHERE id = ?
    ");
    $stmt->execute([$failure_reason, $tx_id]);

    logEvent($tx_id, 'disbursement_failed', $failure_reason);

    return false;
}

// ────────────────────────────────────────────────────────────────────────────────
// Function: Update user totals and recalculate credit score
function updateUserStats($user_id, $amount) {
    global $pdo;

    // Update counters
    $stmt = $pdo->prepare("
        UPDATE users 
        SET 
            total_transactions = total_transactions + 1,
            total_amount = total_amount + ?
        WHERE id = ?
    ");
    $stmt->execute([$amount, $user_id]);

    // Recalculate credit score
    $stats = $pdo->prepare("
        SELECT 
            total_transactions,
            total_amount,
            (SELECT COUNT(*) FROM cargo_pay_mpesa_bank WHERE user_id = ? AND status = 'failed') as failed_count
        FROM users 
        WHERE id = ?
    ");
    $stats->execute([$user_id, $user_id]);
    $data = $stats->fetch(PDO::FETCH_ASSOC);

    if ($data) {
        $score = 300
               + ($data['total_transactions'] * 10)
               + (floor($data['total_amount'] / 1000) * 5)
               - ($data['failed_count'] * 40);

        $score = max(300, min(850, $score));

        $update = $pdo->prepare("UPDATE users SET credit_score = ? WHERE id = ?");
        $update->execute([$score, $user_id]);
    }
}

// ────────────────────────────────────────────────────────────────────────────────
// Helper: Log events to transaction_logs table
function logEvent($transaction_id, $event, $details) {
    global $pdo;

    $stmt = $pdo->prepare("
        INSERT INTO transaction_logs 
        (transaction_id, event, details, created_at)
        VALUES (?, ?, ?, NOW())
    ");
    $stmt->execute([$transaction_id, $event, $details]);
}

?>
