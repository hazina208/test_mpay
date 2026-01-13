<?php
// reconcile.php - Check pending/old transactions after 24h
//require_once 'config.php';
//require_once 'db.php';
require_once 'DB_connection.php';
require_once 'mpesa/cargo/configmpesabank.php';
// Example: Query Daraja for status if needed, or IntaSend status
// For simplicity, assume disbursed = reconciled after 24h
$stmt = $pdo->query("SELECT * FROM cargo_pay_mpesa_bank WHERE status IN ('collected', 'disbursed') AND created_at < DATE_SUB(NOW(), INTERVAL 1 DAY)");
while ($tx = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // In real: Call status API for Daraja/IntaSend
    // Update to 'reconciled'
    $pdo->prepare("UPDATE cargo_pay_mpesa_bank SET status = 'reconciled' WHERE id = ?")->execute([$tx['id']]);
    
    // Update user score
    updateCreditScore($tx['user_id']);
}

function updateCreditScore($user_id) {
    global $pdo;
    
    // Simple 2025 scoring logic
    $stmt = $pdo->prepare("SELECT COUNT(*) as count, SUM(amount) as total, SUM(CASE WHEN status = 'failed' THEN 1 ELSE 0 END) as fails FROM cargo_pay_mpesa_bank WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $data = $stmt->fetch();
    
    $score = 300 + ($data['count'] * 10) + ($data['total'] / 1000) - ($data['fails'] * 50);
    $score = min(850, max(300, $score));
    
    $pdo->prepare("UPDATE cargo_pay_mpesa_to_bank_senders SET credit_score = ?, total_transactions = ?, total_amount = ? WHERE id = ?")
        ->execute([$score, $data['count'], $data['total'], $user_id]);
}
?>
