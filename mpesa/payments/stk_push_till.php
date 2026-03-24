<?php
require_once 'config.php';
require_once 'auth.php';
include '../../DB_connection.php'; // Use PDO connection
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$till   = trim($data['till_number'] ?? '');
$amount = floatval($data['amount'] ?? 0);
$phone  = trim($data['phone_number'] ?? '');

if (empty($till) || $amount < 1 || empty($phone)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'All fields required']);
    exit;
}

if (!preg_match('/^254[17]\d{8}$/', $phone) && preg_match('/^0[17]\d{8}$/', $phone)) {
    $phone = '254' . substr($phone, 1);
}

$reference = 'TILL-' . strtoupper(substr(md5(uniqid()), 0, 12));

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

try {
    $stmt = $pdo->prepare("INSERT INTO till_payments (till_number, amount, fee, total, payer_phone, reference) VALUES (?,?,?,?,?,?)");
    $stmt->execute([$till, $amount, $phone, $reference]);

    echo json_encode([
        'success'   => true,
        'reference' => $reference,
        'till'      => $till,
        'amount'    => $amount,
        'fee'    => $fee,
        'total'    => $total,
        'phone'     => $phone,
        'message'   => 'Ready for payment'
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error']);
}
?>
