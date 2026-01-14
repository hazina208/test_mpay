<?php
require_once 'config.php';
require_once 'auth.php';
include '../../DB_connection.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Invalid method']);
    exit;
}

// Read raw JSON input
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['error' => 'Invalid JSON: ' . json_last_error_msg()]);
    exit;
}

// Extract values (use null coalescing for safety)
$phone     = $data['phone_number'] ?? '';     // ← note key name
$amount    = floatval($data['amount'] ?? 0);
$bank_code = $data['bank_code']   ?? '';
$account   = $data['account']     ?? '';
$bank_name = $data['bank_name'] ?? '';

if (empty($phone) || $amount <= 0 || empty($bank_code) || empty($account)) {
    echo json_encode([
        'error' => 'Missing parameters',
        'received' => array_keys($data)  // ← very helpful for debugging!
    ]);
    exit;
}
// ... rest of your code remains the same (get token, STK push, etc.)
// Get Daraja token
function getDarajaToken() {
    $url = (DARAJA_ENV === 'sandbox') 
        ? 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials'
        : 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
    
    $cred = base64_encode(CONSUMER_KEY . ':' . CONSUMER_SECRET);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Basic $cred"]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $res = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($res, true);
    return $data['access_token'] ?? null;
}

$token = getDarajaToken();
if (!$token) {
    echo json_encode(['error' => 'Failed to get token']);
    exit;
}

$timestamp = date('YmdHis');
$password = base64_encode(MPESA_SHORTCODE . MPESA_PASSKEY . $timestamp);

$data = [
    'BusinessShortCode' => MPESA_SHORTCODE,
    'Password' => $password,
    'Timestamp' => $timestamp,
    'TransactionType' => 'CustomerPayBillOnline',
    'Amount' => $amount,
    'PartyA' => ltrim($phone, '+'),
    'PartyB' => MPESA_SHORTCODE,
    'PhoneNumber' => ltrim($phone, '+'),
    'CallBackURL' => CALLBACK_URL_CARGO_MPESATOBANK,
    'AccountReference' => 'MPAY-' . time(),
    'TransactionDesc' => "Transfer to bank $bank_name"
];

$stkUrl = (DARAJA_ENV === 'sandbox') 
    ? 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest'
    : 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

$ch = curl_init($stkUrl);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $token",
    'Content-Type: application/json'
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$resp = json_decode($response, true);

// Save to DB if initiated
if (isset($resp['ResponseCode']) && $resp['ResponseCode'] == '0') {
    $stmt = $pdo->prepare("
        INSERT INTO cargo_pay_mpesa_bank 
        (user_id, merchant_request_id, checkout_request_id, amount, recipient_bank_code, recipient_account, recipient_name, phone, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')
    ");
    // Assume user_id from session/phone lookup - simplified here
    $user_id = 1; // In real: query users by phone
    $stmt->execute([$user_id, $resp['MerchantRequestID'], $resp['CheckoutRequestID'], $amount, $bank_code, $account, $name, $phone]);
}

echo $response;
?>
