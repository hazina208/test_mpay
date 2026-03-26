<?php
require_once 'config.php';
require_once 'auth.php';
include '../../DB_connection.php';

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

$reference   = trim($input['reference'] ?? '');      // Your TILL-XXXX
$receiptCode = strtoupper(trim($input['mpesa_receipt'] ?? ''));

if (empty($reference) || empty($receiptCode) || strlen($receiptCode) < 8) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid reference or receipt code']);
    exit;
}

try {
    // Update the record with the receipt code and mark as confirmed
    $stmt = $conn->prepare("UPDATE till_payments 
        SET mpesa_receipt = ?, 
            status = 'confirmed', 
            confirmed_at = NOW() 
        WHERE reference = ? AND status = 'pending'");

    $stmt->execute([$receiptCode, $reference]);

    if ($stmt->rowCount() > 0) {
        echo json_encode([
            'success' => true,
            'message' => 'Payment verified successfully!'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No pending transaction found with this reference or already confirmed.'
        ]);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Verification failed']);
}
?>
