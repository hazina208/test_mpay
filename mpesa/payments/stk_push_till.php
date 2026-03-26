<?php
require_once 'config.php';
require_once 'auth.php';
include '../../DB_connection.php';

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

$till   = trim($input['till_number'] ?? '');
$amount = floatval($input['amount'] ?? 0);
$phone  = trim($input['phone_number'] ?? '');

if (empty($till) || $amount < 1 || empty($phone)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'All fields required']);
    exit;
}

// Phone formatting
if (preg_match('/^0[17]\d{8}$/', $phone)) {
    $phone = '254' . substr($phone, 1);
} elseif (!preg_match('/^254[17]\d{8}$/', $phone)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid phone number']);
    exit;
}

$reference = 'TILL-' . strtoupper(substr(md5(uniqid()), 0, 12));

function calculateFee($amount) {
    if ($amount >= 1 && $amount <= 50.99)    return ceil($amount * 0.002);
    if ($amount >= 51 && $amount <= 80.99)   return ceil($amount * 0.005);
    if ($amount >= 81 && $amount <= 100.99)  return ceil($amount * 0.009);
    if ($amount >= 101 && $amount <= 150.99) return ceil($amount * 0.01);
    if ($amount >= 151 && $amount <= 400.99) return ceil($amount * 0.018);
    if ($amount >= 401 && $amount <= 800.99) return ceil($amount * 0.02);
    if ($amount >= 801 && $amount <= 1200.99)return ceil($amount * 0.03);
    if ($amount >= 1201 && $amount <= 3000.99)return ceil($amount * 0.05);
    return 0;
}

$fee = calculateFee($amount);
$total = $amount - $fee;

$qr_text = "Till Number: $till\nAmount: KSh " . number_format($amount, 2) . "\nRef: $reference";

// Create qr_images folder if not exists
$qr_dir = __DIR__ . '/qr_images/';
if (!is_dir($qr_dir)) mkdir($qr_dir, 0755, true);

$qr_filename = $reference . '.png';
$qr_path = $qr_dir . $qr_filename;
$qr_url_path = 'qr_images/' . $qr_filename;   // relative path to save in DB

try {
    // Generate and save QR code image (requires php-qrcode or similar library)
    // Option 1: Simple way using Google Chart API (no extra library)
    $google_qr_url = "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=" . urlencode($qr_text);
    $qr_image = file_get_contents($google_qr_url);
    if ($qr_image !== false) {
        file_put_contents($qr_path, $qr_image);
    }

    // Insert into database (added qr_text and qr_image_path)
    $stmt = $pdo->prepare("INSERT INTO till_payments 
        (till_number, amount, fee, total, payer_phone, reference, qr_text, qr_image_path, status) 
        VALUES (?,?,?,?,?,?,?,?, 'pending')");

    $stmt->execute([$till, $amount, $fee, $total, $phone, $reference, $qr_text, $qr_url_path]);

    echo json_encode([
        'success'       => true,
        'reference'     => $reference,
        'till'          => $till,
        'amount'        => $amount,
        'fee'           => $fee,
        'total'         => $total,
        'phone'         => $phone,
        'qr_text'       => $qr_text,
        'qr_image_path' => $qr_url_path,
        'message'       => 'Ready for payment'
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
