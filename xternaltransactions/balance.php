<?php
// balance.php
include 'config.php';
header('Content-Type: application/json');

$pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);

$data = json_decode(file_get_contents('php://input'), true);
$user_id = $data['user_id'];

$stmt = $pdo->prepare("SELECT balance FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$balance = $stmt->fetchColumn();

echo json_encode(['balance' => $balance]);
?>