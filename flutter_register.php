<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);
include "DB_connection.php"; // Assumes $conn is a PDO instance

try {
    // Check if email or phone already exists
    $checkStmt = $conn->prepare("SELECT id FROM register WHERE email = ? OR phone = ?");
    $checkStmt->execute([$data['email'], $data['phone_number']]);
    if ($checkStmt->rowCount() > 0) {
        echo json_encode(['success' => false, 'message' => 'Email or phone number already exists']);
        exit;
    }
    $checkStmt = null; // Close statement

    // Hash password
    $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

    // Insert new user
    $insertStmt = $conn->prepare("INSERT INTO register (phone, entity, entity_name, first_name, last_name, middle_name, email, password, show_pass, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $insertStmt->execute([
        $data['phone_number'],
        $data['entity'],
        $data['entity_name'],
        $data['first_name'],
        $data['last_name'],
        $data['middle_name'],
        $data['email'],
        $hashedPassword,
        $data['password'], // Note: Storing plaintext password is insecure; consider removing this
        $data['role']
    ]);

    if ($insertStmt->rowCount() > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Registration failed']);
    }
    $insertStmt = null; // Close statement

} catch (PDOException $e) {
    error_log("Registration error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Database error occurred']);
}
?>