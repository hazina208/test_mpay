<?php
require_once 'config.php';
require_once 'auth.php';
include '../../DB_connection.php'; // Use PDO connection
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$paybill_number = trim($input['paybill_number'] ?? '');
$amount = $input['amount'] ?? 0;
$phone_number = $input['phone_number'] ?? '';

$transaction_id = 'PENDING_' . time();

if (empty($amount) || empty($paybill_number) || empty($phone_number)) {
    echo json_encode(['status' => false, 'message' => 'Missing required fields']);
    exit;
}

// Function to calculate percentage fee
function calculateFee($amount) {
    if ($amount >= 1 && $amount <= 50.99) {
        return $amount * 0.002;  // 0.2%
    } elseif ($amount >= 51 && $amount <= 80.99) {
        return $amount * 0.005;  // 0.5%
    } elseif ($amount >= 81 && $amount <= 100.99) {
        return $amount * 0.009;  // 0.9%
    } elseif ($amount >= 101 && $amount <= 150.99) {
        return $amount * 0.01;  // 1%
    } elseif ($amount >= 151 && $amount <= 400.99) {
        return $amount * 0.018;   // 1.8%
    } elseif ($amount >= 401 && $amount <= 800.99) {
        return $amount * 0.02;  // 2%
    } elseif ($amount >= 501 && $amount <= 800.99) {
        return $amount * 0.025;  // 0.25%
    } elseif ($amount >= 801 && $amount <= 1200.99) {
        return $amount * 0.03;  // 0.3%
    } elseif ($amount >= 1201 && $amount <= 1500.99) {
        return $amount * 0.05;  // 0.5%
    } elseif ($amount >= 1501 && $amount <= 3000.99) {
        return $amount * 0.05;  // 0.5%
    } else {
        return 0;  // No fee for amounts outside ranges
    }
}

$fee = calculateFee($amount);
$fee = ceil($fee);  // Ceil to integer (adjust rounding if needed)
$total = $amount - $fee;  // Net amount after deducting fee from receiver
$status = 'Pending';  // Define initial status

try {
    // Save payment details to database
    $stmt = $conn->prepare("INSERT INTO cargo_pays_paybill (paybill_no, amount, fee, total, phone_number, status, transaction_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$paybill_number, $amount, $fee, $total, $phone_number, $status, $transaction_id]);
    $payment_id = $conn->lastInsertId();
    $stmt = null; // Close statement
} catch (PDOException $e) {
    error_log("Error inserting payment: " . $e->getMessage());
    echo json_encode(['status' => false, 'message' => 'Database error occurred']);
    exit;
}

try {
    $access_token = getAccessToken();
} catch (Error $e) {  // Catch "Undefined constant" as Error
    error_log("Auth error: " . $e->getMessage());
    echo json_encode(['status' => false, 'message' => 'Authentication setup failed: ' . $e->getMessage()]);
    exit;
}
if (!$access_token) {
    echo json_encode(['status' => false, 'message' => 'Failed to get access token']);
    exit;
}

$timestamp = date('YmdHis');
$password = base64_encode($paybill_number . MPESA_PASSKEY . $timestamp);
$url = MPESA_ENV == 'sandbox'
    ? 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest'
    : 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

$payload = [
    'BusinessShortCode' => $paybill_number,
    'Password' => $password,
    'Timestamp' => $timestamp,
    'TransactionType' => 'CustomerPayBillOnline',
    'Amount' => $total,  // Charge the total (amount + fee)
    'PartyA' => $phone_number,
    'PartyB' => $paybill_number,
    'PhoneNumber' => $phone_number,
    'CallBackURL' => MPESA_CALLBACK_URL,
    'AccountReference' => 'Cargo_' . $payment_id,
    'TransactionDesc' => 'Payment for Cargo  - Paybill Number: ' . $paybill_number
];

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Authorization: Bearer ' . $access_token]);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));
$response_str = curl_exec($curl);
curl_close($curl);

$response = json_decode($response_str);

if (isset($response->ResponseCode) && $response->ResponseCode == 0) {
    try {
        // Save STK details to database
        $stmt2 = $conn->prepare("UPDATE cargo_pays_paybill SET transaction_date = ?, CheckoutRequestID = ?, merchant_request_id = ? WHERE id = ?");
        $stmt2->execute([$timestamp, $response->CheckoutRequestID, $response->MerchantRequestID, $payment_id]);
        $stmt2 = null; // Close statement
        
        echo json_encode(['status' => true, 'message' => 'STK Push initiated. Please check your phone.']);
    } catch (PDOException $e) {
        error_log("Error updating payment: " . $e->getMessage());
        echo json_encode(['status' => false, 'message' => 'Database update failed']);
    }
} else {
    $error_msg = isset($response->errorMessage) ? $response->errorMessage : (isset($response['errorMessage']) ? $response['errorMessage'] : 'Unknown error');
    echo json_encode(['status' => false, 'message' => 'STK Push failed: ' . $error_msg]);
}
?>
