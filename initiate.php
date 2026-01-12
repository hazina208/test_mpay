<?php
// backend/api/initiate.php
// Public API endpoint called by Flutter app to start a transfer

require_once 'DB_connection.php';
require_once 'mpesa/cargo/configmpesabank.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Allow Flutter (CORS) - restrict in production!
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Only allow POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true) ?? $_POST;

// Required fields
$required = ['phone', 'amount', 'bank_code', 'account'];
foreach ($required as $field) {
    if (empty($data[$field])) {
        http_response_code(400);
        echo json_encode(['error' => "Missing required field: $field"]);
        exit;
    }
}

$phone   = trim($data['phone']);
$amount  = floatval($data['amount']);
$bank_code = $data['bank_code'];
$account = $data['account'];
$name    = $data['name'] ?? '';

// Basic validation (add more in production: phone format, amount limits, etc.)
if ($amount <= 0 || $amount > 999999) {
    echo json_encode(['error' => 'Invalid amount']);
    exit;
}
if (!preg_match('/^2547\d{8}$/', $phone)) {
    echo json_encode(['error' => 'Invalid phone number format (use 2547xxxxxxxx)']);
    exit;
}

// Now call the STK Push logic (we can include stk-push.php or duplicate the code here)
// For simplicity, we duplicate the core logic here (or require 'stk-push.php' and call a function)

$token = getDarajaToken(); // Function from stk-push.php or defined below
if (!$token) {
    echo json_encode(['error' => 'Failed to get access token']);
    exit;
}

$timestamp = date('YmdHis');
$password = base64_encode(MPESA_SHORTCODE . MPESA_PASSKEY . $timestamp);

$payload = [
    'BusinessShortCode' => MPESA_SHORTCODE,
    'Password'          => $password,
    'Timestamp'         => $timestamp,
    'TransactionType'   => 'CustomerPayBillOnline',
    'Amount'            => $amount,
    'PartyA'            => ltrim($phone, '+'),
    'PartyB'            => MPESA_SHORTCODE,
    'PhoneNumber'       => ltrim($phone, '+'),
    'CallBackURL'       => CALLBACK_URL_MPESA_BANK,
    'AccountReference'  => 'Mpay-' . time(),
    'TransactionDesc'   => "Transfer to bank $bank_code"
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
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$resp = json_decode($response, true);

if ($httpCode === 200 && isset($resp['ResponseCode']) && $resp['ResponseCode'] === '0') {
    // Save to DB (simplified - get or create user_id by phone)
    $userStmt = $pdo->prepare("SELECT id FROM cargo_pay_mpesa_to_bank_senders WHERE phone = ?");
    $userStmt->execute([$phone]);
    $user = $userStmt->fetch();
    $user_id = $user ? $user['id'] : 1; // Fallback/create new user logic here in real

    $stmt = $pdo->prepare("
        INSERT INTO cargo_pay_mpesa_bank 
        (user_id, merchant_request_id, checkout_request_id, amount, recipient_bank_code, recipient_account, recipient_name, phone, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')
    ");
    $stmt->execute([
        $user_id,
        $resp['MerchantRequestID'],
        $resp['CheckoutRequestID'],
        $amount,
        $bank_code,
        $account,
        $name,
        $phone
    ]);

    echo json_encode([
        'success' => true,
        'message' => 'STK Push initiated successfully',
        'merchant_request_id' => $resp['MerchantRequestID'],
        'checkout_request_id' => $resp['CheckoutRequestID']
    ]);
} else {
    echo json_encode([
        'success' => false,
        'error' => $resp['errorMessage'] ?? $resp['ResponseDescription'] ?? 'Failed to initiate STK Push',
        'details' => $response // for debugging
    ]);
}

// Reuse or define getDarajaToken() here if not requiring stk-push.php
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
?>
