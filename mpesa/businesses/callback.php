<?php
// callback.php - Fixed for clean JSON response and Render.com compatibility
header("Content-Type: application/json");

$data = file_get_contents("php://input");

// Use error_log for debugging (view in Render Logs) instead of file_put_contents
error_log("M-Pesa Callback Raw Data: " . $data);

// Fallback to /tmp if you prefer file logging (writable on Render)
// $logFile = "/tmp/callback.json";
// file_put_contents($logFile, $data . PHP_EOL, FILE_APPEND | LOCK_EX);

$callback = json_decode($data, true);

// Make sure callback structure exists
if (isset($callback['Body']['stkCallback'])) {
    $stkCallback = $callback['Body']['stkCallback'];
    $merchantRequestID = $stkCallback['MerchantRequestID'];
    $checkoutRequestID = $stkCallback['CheckoutRequestID'];
    $resultCode = $stkCallback['ResultCode'];
    $resultDesc = $stkCallback['ResultDesc'];
    
    require_once '../../DB_connection.php'; // Assumes $conn is PDO instance from Clever Cloud
    
    try {
        if ($resultCode == 0) { // Success
            $callbackMetadata = $stkCallback['CallbackMetadata']['Item'];
            $amount = $callbackMetadata[0]['Value']; // Amount
            $mpesaReceiptNumber = $callbackMetadata[1]['Value']; // M-Pesa receipt
            $transactionDate = $callbackMetadata[3]['Value']; // Timestamp
            $phoneNumber = $callbackMetadata[4]['Value']; // Phone
            $status_complete = "Complete";
            
            // Update DB transaction
            $stmt = $conn->prepare("UPDATE business_payments SET status = ?, transaction_id = ? WHERE CheckoutRequestID = ?");
            $stmt->execute([$status_complete, $mpesaReceiptNumber, $checkoutRequestID]);
            $stmt = null; // Close statement
            
            error_log("M-Pesa Success: Updated CheckoutRequestID $checkoutRequestID with Receipt $mpesaReceiptNumber");
        } else {
            // Failed transaction
            $status_failed = "Failed";
            $stmt = $conn->prepare("UPDATE business_payments SET status = ? WHERE CheckoutRequestID = ?");
            $stmt->execute([$status_failed, $checkoutRequestID]);
            $stmt = null; // Close statement
            
            error_log("M-Pesa Failed: $resultDesc for CheckoutRequestID $checkoutRequestID");
        }
    } catch (PDOException $e) {
        error_log("M-Pesa callback DB error for CheckoutRequestID $checkoutRequestID: " . $e->getMessage());
    }
} else {
    error_log("M-Pesa Callback: No stkCallback in payload");
}

// Always respond with 200 OK and standard acknowledgment (M-Pesa expects this)
http_response_code(200);
echo json_encode(['ResultDesc' => 'Accepted']);
?>