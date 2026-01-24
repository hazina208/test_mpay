<?php
// backend/api/initiate.php
require_once '../../DB_connection.php';
require_once 'auth.php';
require_once 'config.php';
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}
$data = json_decode(file_get_contents('php://input'), true) ?? $_POST;
// Required fields
$required = ['phone_number', 'amount', 'bank_code', 'bank_name', 'account'];
foreach ($required as $field) {
    if (empty($data[$field])) {
        http_response_code(400);
        echo json_encode(['error' => "Missing required field: $field"]);
        exit;
    }
}
$phone = trim($data['phone_number']);
$amount = floatval($data['amount']);
$bank_code = $data['bank_code'];
$account = $data['account'];
$bank_name = $data['bank_name'] ?? '';
$email = $data['email'] ?? '';  
$branch_id = isset($data['branch_id']) ? (int)$data['branch_id'] : null; 
// Validation
if ($amount <= 0 || $amount > 999999) {
    echo json_encode(['error' => 'Invalid amount']);
    exit;
}
if (!preg_match('/^2547\d{8}$/', $phone)) {
    echo json_encode(['error' => 'Invalid phone number']);
    exit;
}
// Get or create user in users (since it has phone, email, stats)
$userStmt = $conn->prepare("SELECT user_id, email, branch_id FROM users WHERE phone = ? OR email = ?");
$userStmt->execute([$phone, $email]);
$user = $userStmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    $user_id = $user['user_id'];
    $user_email = $user['email'];
    $branch_id = $user['branch_id'] ?? $branch_id; 
} else {
    // Create in users (link to register if email matches)
    $regStmt = $conn->prepare("SELECT id, branch_id FROM register WHERE email = ?");
    $regStmt->execute([$email]);
    $reg = $regStmt->fetch(PDO::FETCH_ASSOC);
    $reg_id = $reg ? $reg['id'] : null;
    $branch_id = $reg ? $reg['branch_id'] : $branch_id;

    $insert = $conn->prepare("
        INSERT INTO users (user_id, phone, branch_id, email, credit_score, total_transactions, total_amount)
        VALUES (?, ?, ?, ?, 300, 0, 0) 
    ");
    $insert->execute([$reg_id, $phone, $branch_id, $email]);
    $user_id = $reg_id ?? $conn->lastInsertId(); 
    $user_email = $email;
}
// If no branch_id at all → error or default
if ($branch_id === null) {
    echo json_encode(['error' => 'No branch selected. Please contact support or log in again.']);
    exit;
}
// ─────────────────────────────────────────────
// Initiate STK Push
$token = getDarajaToken();
if (!$token) {
    echo json_encode(['error' => 'Failed to get token']);
    exit;
}
$timestamp = date('YmdHis');
$password = base64_encode(CARGO_MPESA_SHORTCODE . MPESA_PASSKEY . $timestamp);
$payload = [
    'BusinessShortCode' => CARGO_MPESA_SHORTCODE,
    'Password' => $password,
    'Timestamp' => $timestamp,
    'TransactionType' => 'CustomerPayBillOnline',
    'Amount' => $amount,
    'PartyA' => ltrim($phone, '+'),
    'PartyB' => CARGO_MPESA_SHORTCODE,
    'PhoneNumber' => ltrim($phone, '+'),
    'CallBackURL' => CALLBACK_URL_CARGO_MPESATOBANK,
    'AccountReference' => 'Mpay-' . time(),
    'TransactionDesc' => "Transfer to bank $bank_name"
];
$stkUrl = (MPESA_ENV === 'sandbox')
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
    // Insert transaction WITH branch_id
    $stmt = $conn->prepare("
        INSERT INTO cargo_pay_mpesa_bank
        (user_id, branch_id, email, merchant_request_id, checkout_request_id, amount,
         recipient_bank_code, recipient_account, recipient_bank_name, phone, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')
    ");
    $stmt->execute([
        $user_id,
        $branch_id,
        $user_email,
        $resp['MerchantRequestID'],
        $resp['CheckoutRequestID'],
        $amount,
        $bank_code,
        $account,
        $bank_name,
        $phone
    ]);
    echo json_encode([
        'success' => true,
        'message' => 'STK Push initiated successfully. Please complete payment on your phone.',
        'merchant_request_id' => $resp['MerchantRequestID'],
        'checkout_request_id' => $resp['CheckoutRequestID']
    ]);
} else {
    echo json_encode([
        'success' => false,
        'error' => $resp['ResponseDescription'] ?? 'Failed to initiate STK Push',
        'details' => $resp
    ]);
}
function getDarajaToken() {
    $url = (MPESA_ENV === 'sandbox')
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
