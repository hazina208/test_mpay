<?php
require_once 'config.php';
require_once 'auth.php';
include '../../DB_connection.php'; // Use PDO connection

header('Content-Type: application/json');

// Read JSON from Flutter
$input = json_decode(file_get_contents('php://input'), true);

// Use $input, NOT $data
$till   = trim($input['till_number'] ?? '');
$amount = floatval($input['amount'] ?? 0);
$phone  = trim($input['phone_number'] ?? '');

if (empty($till) || $amount < 1 || empty($phone)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'All fields required']);
    exit;
}

// Fix phone number format
if (preg_match('/^0[17]\d{8}$/', $phone)) {
    $phone = '254' . substr($phone, 1);
} elseif (!preg_match('/^254[17]\d{8}$/', $phone)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid phone number format']);
    exit;
}

$reference = 'TILL-' . strtoupper(substr(md5(uniqid()), 0, 12));

// Fee calculation (fixed your duplicate condition)
function calculateFee($amount) {
    if ($amount >= 1 && $amount <= 50.99)    return ceil($amount * 0.002);
    if ($amount >= 51 && $amount <= 80.99)   return ceil($amount * 0.005);
    if ($amount >= 81 && $amount <= 100.99)  return ceil($amount * 0.009);
    if ($amount >= 101 && $amount <= 150.99) return ceil($amount * 0.01);
    if ($amount >= 151 && $amount <= 400.99) return ceil($amount * 0.018);
    if ($amount >= 401 && $amount <= 800.99) return ceil($amount * 0.02);
    if ($amount >= 801 && $amount <= 1200.99)return ceil($amount * 0.03);
    if ($amount >= 1201 && $amount <= 1500.99)return ceil($amount * 0.05);
    if ($amount >= 1501 && $amount <= 3000.99)return ceil($amount * 0.05);
    return 0;
}

$fee = calculateFee($amount);
$total = $amount - $fee;   // or $amount + $fee depending on your logic

try {
    $stmt = $pdo->prepare("INSERT INTO till_payments 
        (till_number, amount, fee, total, payer_phone, reference) 
        VALUES (?,?,?,?,?,?)");

    $stmt->execute([$till, $amount, $fee, $total, $phone, $reference]);

    echo json_encode([
        'success'   => true,
        'reference' => $reference,
        'till'      => $till,
        'amount'    => $amount,
        'fee'       => $fee,
        'total'     => $total,
        'phone'     => $phone,
        'message'   => 'Ready for payment'
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false, 
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
?>
