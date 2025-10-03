<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'] ?? '';

if (empty($email)) {
    echo json_encode(['success' => false, 'message' => 'Email is required']);
    exit;
}

// Database connection
include "DB_connection.php";

try {
    // Fetch user details using the email
    $stmt = $conn->prepare("SELECT first_name, middle_name, last_name, phone, position, entity, entity_name, email, password, show_pass, role FROM register WHERE email = ? LIMIT 1");
    $stmt->bindParam(1, $email);
    $stmt->execute();
    
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
        echo json_encode(['success' => false, 'message' => 'User not found']);
        $stmt->closeCursor();
        $conn = null;
        exit;
    }

    $logout_time = date('Y-m-d H:i:s'); // Current timestamp for logout

    // Insert logout log entry into logs table
    $log_sql = "INSERT INTO logout_logs (first_name, last_name, entity_name, email, role, logout_time) VALUES (?, ?, ?, ?, ?, ?)";
    $log_stmt = $conn->prepare($log_sql);
    $log_stmt->bindParam(1, $row['first_name']);
    $log_stmt->bindParam(2, $row['last_name']);
    $log_stmt->bindParam(3, $row['entity_name']);
    $log_stmt->bindParam(4, $email);
    $log_stmt->bindParam(5, $row['role'], PDO::PARAM_INT);
    $log_stmt->bindParam(6, $logout_time);
    $log_stmt->execute();
    $log_stmt->closeCursor();

    // Optional: Destroy session if it exists (for web context, though this is API)
    session_start();
    session_destroy();

    echo json_encode(['success' => true, 'message' => 'Logout successful']);
    
    $stmt->closeCursor();
    $conn = null; // Close connection
} catch (PDOException $e) {
    error_log("Error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Database error']);
}
?>