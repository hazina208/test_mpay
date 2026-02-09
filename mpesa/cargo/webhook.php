<?php
include 'config.php';

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verify webhook (optional: check signature if IntaSend provides)
$payload = file_get_contents('php://input');
$data = json_decode($payload, true);

// Example payload: {'event': 'send_money_update', 'tracking_id': 'XXX', 'state': 'COMPLETED', 'amount': 1000}
// Update transaction status
if (isset($data['tracking_id']) && isset($data['state'])) {
    $tracking_id = mysqli_real_escape_string($conn, $data['tracking_id']);
    $status = strtoupper($data['state']); // e.g., 'COMPLETED'

    $sql = "UPDATE transactions SET status = '$status' WHERE transaction_id = '$tracking_id'";
    mysqli_query($conn, $sql);

    // Log cash flow (outflow for payout)
    $tx_query = mysqli_query($conn, "SELECT id, amount FROM transactions WHERE transaction_id = '$tracking_id'");
    $tx = mysqli_fetch_assoc($tx_query);
    if ($tx && $status == 'COMPLETED') {
        mysqli_query($conn, "INSERT INTO logs (transaction_id, event_type, amount, description) VALUES ({$tx['id']}, 'OUTFLOW', {$tx['amount']}, 'Payout completed')");

        // Update credit score (simple: +10 per completed tx)
        $user_id_query = mysqli_query($conn, "SELECT user_id FROM transactions WHERE id = {$tx['id']}");
        $user = mysqli_fetch_assoc($user_id_query);
        mysqli_query($conn, "UPDATE users SET credit_score = credit_score + 10 WHERE id = {$user['user_id']}");
    }

    http_response_code(200); // Acknowledge
} else {
    http_response_code(400);
}

mysqli_close($conn);
