<?php
ob_start(); // Prevent any accidental output before headers

require_once 'config.php';
include "../../DB_connection.php"; // This gives us $conn (PDO)

// Set headers early
header('Content-Type: application/json');

// For manual testing in browser (GET ?test=1)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['test'])) {
    echo json_encode([
        'status' => 'ok',
        'message' => 'Webhook endpoint is reachable. Use POST with JSON payload for real events.',
        'received' => $_GET,
        'php_input' => file_get_contents('php://input') // usually empty on GET
    ]);
    http_response_code(200);
    exit;
}

// Only accept POST for real webhooks
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed. Use POST.']);
    exit;
}

// Read raw POST body
$payload = file_get_contents('php://input');
$data = json_decode($payload, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON: ' . json_last_error_msg()]);
    exit;
}

// 1. Handle IntaSend webhook verification challenge (one-time when adding URL in dashboard)
if (isset($data['challenge']) && !empty($data['challenge'])) {
    // Echo back EXACTLY the challenge string (IntaSend requirement)
    echo $data['challenge'];
    http_response_code(200);
    exit; // Important: stop here
}

// 2. Handle real payout/send-money status update
if (!isset($data['tracking_id']) || !isset($data['state'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing tracking_id or state']);
    exit;
}

try {
    $tracking_id = $data['tracking_id'];
    $status = strtoupper($data['state']); // e.g. COMPLETED, FAILED, PROCESSING

    // Update main transaction status
    $stmt = $conn->prepare("
        UPDATE cargo_pay_bank_bank 
        SET status = :status 
        WHERE transaction_id = :tracking_id
    ");
    $stmt->execute([':status' => $status, ':tracking_id' => $tracking_id]);

    $affected = $stmt->rowCount();

    if ($affected === 0) {
        // Optional: log that no row was found
        error_log("Webhook: No transaction found for tracking_id $tracking_id");
    }

    // If COMPLETED → log outflow & update credit score
    if ($status === 'COMPLETED') {
        // Get transaction details
        $txStmt = $conn->prepare("
            SELECT id, amount, user_id 
            FROM cargo_pay_bank_bank 
            WHERE transaction_id = :tracking_id
        ");
        $txStmt->execute([':tracking_id' => $tracking_id]);
        $tx = $txStmt->fetch(PDO::FETCH_ASSOC);

        if ($tx) {
            // Log outflow
            $logStmt = $conn->prepare("
                INSERT INTO cargo_pay_bank_bank_logs 
                (transaction_id, event_type, amount, description) 
                VALUES (:tx_id, 'OUTFLOW', :amount, 'Payout completed')
            ");
            $logStmt->execute([
                ':tx_id'   => $tx['id'],
                ':amount'  => $tx['amount']
            ]);

            // Update credit score (+10)
            $scoreStmt = $conn->prepare("
                UPDATE banktobankusers  -- Note: table name was bankbankusers in your old code — confirm!
                SET credit_score = credit_score + 10 
                WHERE user_id = :user_id
            ");
            $scoreStmt->execute([':user_id' => $tx['user_id']]);
        }
    }

    // Always acknowledge with 200
    http_response_code(200);
    echo json_encode(['status' => 'received', 'tracking_id' => $tracking_id, 'new_status' => $status]);

} catch (PDOException $e) {
    error_log("Webhook DB error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Database error']);
}

$conn = null; // Close PDO
