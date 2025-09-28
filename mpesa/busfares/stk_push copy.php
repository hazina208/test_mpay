<?php
require_once 'config.php';
require_once 'auth.php';

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

// Save payment details to database
$stmt = $conn->prepare("INSERT INTO payments (sacco, amount, fleet_no, phone_number,status) VALUES (?, ?, ?, ?, 'pending')");
$stmt->bind_param("sdss", $sacco, $amount, $fleet_no, $phone_number);
$stmt->execute();
$payment_id = $conn->insert_id;
$stmt->close();

// Prepare STK Push
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
    'Amount' => $amount,
    'PartyA' => $phone_number,
    'PartyB' => MPESA_SHORTCODE,
    'PhoneNumber' => $phone_number,
    'CallBackURL' => MPESA_CALLBACK_URL,
    'AccountReference' => 'BusFare_' . $payment_id,
    'TransactionDesc' => 'Payment for ' . $sacco . ' - Fleet: ' . $fleet_no
];

$headers = [
    'Authorization: Bearer ' . $access_token,
    'Content-Type: application/json'
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);


$response = json_decode($response, true);
if (isset($response['ResponseCode']) && $response['ResponseCode'] == '0') {  
    echo json_encode(['status' => true, 'message' => 'STK Push initiated. Please check your phone.']);

} else {
    echo json_encode(['status' => false, 'message' => 'STK Push failed: ' . ($response['errorMessage'] ?? 'Unknown error')]);
}


?>