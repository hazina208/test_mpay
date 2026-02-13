<?php
ob_start(); // Buffer output to prevent "headers already sent"
//session_start();
require_once 'config.php';
include "../../DB_connection.php"; // PDO connection
// Verify webhook (optional: check signature if IntaSend provides)
$payload = file_get_contents('php://input');
$data = json_decode($payload, true);
// Check if this is the verification challenge request
if (isset($data['challenge']) && !empty($data['challenge'])) {
    // Simply echo back the exact challenge string
    echo $data['challenge'];
    http_response_code(200);
    exit;  // Stop here — don't process as normal webhook
}

// Example payload: {'event': 'send_money_update', 'tracking_id': 'XXX', 'state': 'COMPLETED', 'amount': 1000}
// Update transaction status
if (isset($data['tracking_id']) && isset($data['state'])) {
    $tracking_id = mysqli_real_escape_string($conn, $data['tracking_id']);
    $status = strtoupper($data['state']); // e.g., 'COMPLETED'

    $sql = "UPDATE cargo_pay_bank_bank SET status = '$status' WHERE transaction_id = '$tracking_id'";
    mysqli_query($conn, $sql);

    // Log cash flow (outflow for payout)
    $tx_query = mysqli_query($conn, "SELECT id, amount FROM cargo_pay_bank_bank WHERE transaction_id = '$tracking_id'");
    $tx = mysqli_fetch_assoc($tx_query);
    if ($tx && $status == 'COMPLETED') {
        mysqli_query($conn, "INSERT INTO cargo_pay_bank_bank_logs (transaction_id, event_type, amount, description) VALUES ({$tx['id']}, 'OUTFLOW', {$tx['amount']}, 'Payout completed')");

        // Update credit score (simple: +10 per completed tx)
        $user_id_query = mysqli_query($conn, "SELECT user_id FROM cargo_pay_bank_bank WHERE id = {$tx['id']}");
        $user = mysqli_fetch_assoc($user_id_query);
        mysqli_query($conn, "UPDATE bankbankusers SET credit_score = credit_score + 10 WHERE id = {$user['user_id']}");
    }

    http_response_code(200); // Acknowledge
} else {
    http_response_code(400);
}

mysqli_close($conn);
