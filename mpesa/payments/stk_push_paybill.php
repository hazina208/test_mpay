<?php
require_once 'config.php';
require_once 'auth.php';
include '../../DB_connection.php';
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$business = trim($input['business_number'] ?? '');      // ← changed
$account = trim($input['account_number'] ?? '');        // ← new
$amount = floatval($input['amount'] ?? 0);
$phone = trim($input['phone_number'] ?? '');

if (empty($business) || empty($account) || $amount < 1 || empty($phone)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'All fields required']);
    exit;
}

// Phone formatting (same as before)
if (preg_match('/^0[17]\d{8}$/', $phone)) {
    $phone = '254' . substr($phone, 1);
} elseif (!preg_match('/^254[17]\d{8}$/', $phone)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid phone number']);
    exit;
}

$reference = 'PAYBILL-' . strtoupper(substr(md5(uniqid()), 0, 12));  // ← changed prefix

// calculateFee function stays exactly the same
function calculateFee($amount) { ... }  // copy from original

$fee = calculateFee($amount);
$total = $amount - $fee;

$qr_text = "Paybill: $business\nAccount: $account\nAmount: KSh " . number_format($amount, 2) . "\nRef: $reference";

// QR image generation (exactly the same)
$qr_dir = __DIR__ . '/qr_images/';
if (!is_dir($qr_dir)) mkdir($qr_dir, 0755, true);
$qr_filename = $reference . '.png';
$qr_path = $qr_dir . $qr_filename;
$qr_url_path = 'qr_images/' . $qr_filename;

try {
    $google_qr_url = "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=" . urlencode($qr_text);
    $qr_image = file_get_contents($google_qr_url);
    if ($qr_image !== false) {
        file_put_contents($qr_path, $qr_image);
    }

    // Insert into NEW table (you need to create paybill_payments with matching columns)
    $stmt = $conn->prepare("INSERT INTO paybill_payments
        (business_number, account_number, amount, fee, total, payer_phone, reference, qr_text, qr_image_path, status)
        VALUES (?,?,?,?,?,?,?,?,?, 'pending')");
    $stmt->execute([$business, $account, $amount, $fee, $total, $phone, $reference, $qr_text, $qr_url_path]);

    echo json_encode([
        'success' => true,
        'reference' => $reference,
        'paybill' => $business,          // ← matches frontend
        'account' => $account,           // ← matches frontend
        'amount' => $amount,
        'fee' => $fee,
        'total' => $total,
        'phone' => $phone,
        'qr_text' => $qr_text,
        'qr_image_path' => $qr_url_path,
        'message' => 'Ready for payment'
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
