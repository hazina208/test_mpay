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

    if ($resultCode == 0) { // success
        $callbackMetadata = $stkCallback['CallbackMetadata']['Item'];
        $amount = $callbackMetadata[0]['Value'];
        $mpesaReceiptNumber = $callbackMetadata[1]['Value'];
        $transactionDate = $callbackMetadata[3]['Value'];
        $phoneNumber = $callbackMetadata[4]['Value'];
        $status_complete = "Complete";
        $status_failed = "Failed";

        // Update your DB transaction here
        require_once '../../connection.php';

        $stmt = $conn->prepare("UPDATE insurance_payments SET status=?, transaction_id=? WHERE CheckoutRequestID=?");
        $stmt->bind_param("sss", $status_complete, $mpesaReceiptNumber, $checkoutRequestID);
        $stmt->execute();
    } else {
        // Failed transaction
        require_once '../../connection.php';
        $stmt = $conn->prepare("UPDATE insurance_payments SET status=? WHERE CheckoutRequestID=?"); 
        $stmt->bind_param("ss", $status_failed, $checkoutRequestID);
        $stmt->execute();
    }
}
?>
