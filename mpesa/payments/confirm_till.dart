<?php
require_once 'config.php';
require_once 'auth.php';
include '../../DB_connection.php'; // Use PDO connection

$data = json_decode(file_get_contents('php://input'), true);

$reference = trim($data['reference'] ?? '');
$receipt   = trim($data['mpesa_receipt'] ?? '');

if (empty($reference) || empty($receipt) || strlen($receipt) !== 10) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Reference + valid 10-char M-Pesa receipt required']);
    exit;
}

try {
    $stmt = $pdo->prepare("UPDATE till_payments SET status='confirmed', mpesa_receipt=?, updated_at=NOW() WHERE reference=? AND status='pending'");
    $stmt->execute([$receipt, $reference]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Payment confirmed successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Transaction not found or already confirmed']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Server error']);
}
?>
