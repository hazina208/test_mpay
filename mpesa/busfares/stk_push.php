<?php
require_once 'config.php';
require_once 'auth.php';
include '../../DB_connection.php'; // Use PDO connection
header('Content-Type: application/json');
$input = json_decode(file_get_contents('php://input'), true);
$sacco = $input['sacco'] ?? '';
$amount = $input['amount'] ?? 0;
$fleet_no = $input['fleet_no'] ?? '';
$phone_number = $input['phone_number'] ?? '';
if (empty($sacco) || empty($amount) || empty($fleet_no) || empty($phone_number)) {
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
$total = ceil($amount + $fee);  // Ceil to integer for M-Pesa (adjust rounding if needed)
$fee = $total - $amount;  // Update fee to match the ceiled total
$status = 'Pending';  // Define initial status
// Check connection before STK push
if (!$conn || !($conn instanceof PDO)) {
    error_log("No valid PDO connection available");
    echo json_encode(['status' => false, 'message' => 'No database connection']);
    exit;
}
try {
    // Prepare STK Push first
    $access_token = getAccessToken();
    if (!$access_token) {
        echo json_encode(['status' => false, 'message' => 'Failed to get access token']);
        exit;
    }
    $timestamp = date('YmdHis');
    $password = base64_encode(MPESA_SHORTCODE . MPESA_PASSKEY . $timestamp);
    $url = MPESA_ENV == 'sandbox'
        ? 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest'
        : 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
    $payload = [
        'BusinessShortCode' => MPESA_SHORTCODE,
        'Password' => $password,
        'Timestamp' => $timestamp,
        'TransactionType' => 'CustomerPayBillOnline',
        'Amount' => $total,  // Charge the total (amount + fee)
        'PartyA' => $phone_number,
        'PartyB' => MPESA_SHORTCODE,
        'PhoneNumber' => $phone_number,
        'CallBackURL' => MPESA_CALLBACK_URL,
        'AccountReference' => 'BusFare_' . uniqid(),  // Unique ref without DB ID yet
        'TransactionDesc' => 'Payment for ' . $sacco . ' - Fleet: ' . $fleet_no
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
        // Single INSERT after STK success, including all fields
        $stmt = $conn->prepare("INSERT INTO bus_fares (sacco, amount, fee, total, fleet_no, phone_number, status, transaction_date, CheckoutRequestID, merchant_request_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$sacco, $amount, $fee, $total, $fleet_no, $phone_number, $status, $timestamp, $response->CheckoutRequestID, $response->MerchantRequestID]);
        $stmt = null; // Close statement
        echo json_encode(['status' => true, 'message' => 'STK Push initiated. Please check your phone.']);
    } else {
        $error_msg = isset($response->errorMessage) ? $response->errorMessage : (isset($response['errorMessage']) ? $response['errorMessage'] : 'Unknown error');
        echo json_encode(['status' => false, 'message' => 'STK Push failed: ' . $error_msg]);
    }
} catch (Exception $e) {  // Broader catch for cURL/STK errors
    error_log("Error in STK process: " . $e->getMessage());
    echo json_encode(['status' => false, 'message' => 'STK error: ' . $e->getMessage()]);
}
?>