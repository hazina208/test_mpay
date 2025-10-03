<?php
// callback.php
header("Content-Type: application/json");

$data = file_get_contents("php://input");
$logFile = "callback.json"; // for debugging
file_put_contents($logFile, $data . PHP_EOL, FILE_APPEND);

$callback = json_decode($data, true);

// Make sure callback structure exists
if (isset($callback['Body']['stkCallback'])) {
    $stkCallback = $callback['Body']['stkCallback'];
    $merchantRequestID = $stkCallback['MerchantRequestID'];
    $checkoutRequestID = $stkCallback['CheckoutRequestID'];
    $resultCode = $stkCallback['ResultCode'];
    $resultDesc = $stkCallback['ResultDesc'];

    require_once '../../DB_connection.php'; // Assumes $conn is PDO instance

    try {
        if ($resultCode == 0) { // success
            $callbackMetadata = $stkCallback['CallbackMetadata']['Item'];
            $amount = $callbackMetadata[0]['Value'];
            $mpesaReceiptNumber = $callbackMetadata[1]['Value'];
            $transactionDate = $callbackMetadata[3]['Value'];
            $phoneNumber = $callbackMetadata[4]['Value'];
            $status_complete = "Complete";

            // Update DB transaction
            $stmt = $conn->prepare("UPDATE chama_payments SET status = ?, transaction_id = ? WHERE CheckoutRequestID = ?");
            $stmt->execute([$status_complete, $mpesaReceiptNumber, $checkoutRequestID]);
            $stmt = null; // Close statement
        } else {
            // Failed transaction
            $status_failed = "Failed";
            $stmt = $conn->prepare("UPDATE chama_payments SET status = ? WHERE CheckoutRequestID = ?");
            $stmt->execute([$status_failed, $checkoutRequestID]);
            $stmt = null; // Close statement
        }
        // Log success for debugging
        error_log("M-Pesa callback processed for CheckoutRequestID: $checkoutRequestID");

    } catch (PDOException $e) {
        // Log error for debugging
        error_log("M-Pesa callback DB error: " . $e->getMessage());
        // Optionally, you could insert into an error log table here
    }
}

// Always respond with 200 OK for M-Pesa (empty body is fine)
http_response_code(200);
echo json_encode(['ResultDesc' => 'Accepted']); // Standard M-Pesa acknowledgment
?>
