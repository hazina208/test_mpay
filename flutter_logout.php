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
    error_log("Logout attempt for email: $email");  // Log start

    // Fetch user details using the email
    $stmt = $conn->prepare("SELECT first_name, last_name, entity_name, email, role FROM register WHERE email = ? LIMIT 1");
    if (!$stmt) {
        throw new PDOException("Prepare failed: " . implode(", ", $conn->errorInfo()));
    }
    $stmt->bindParam(1, $email);
    $stmt->execute();
    
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
        error_log("User not found: $email");
        echo json_encode(['success' => false, 'message' => 'User not found']);
        $stmt->closeCursor();
        $conn = null;
        exit;
    }
    error_log("User found: " . $row['first_name'] . " " . $row['last_name']);  // Log success fetch

    $logout_time = date('Y-m-d H:i:s'); // Current timestamp for logout
    // Insert logout log entry into logs table
    $log_sql = "INSERT INTO logout_logs (first_name, last_name, entity_name, email, role, logout_time) VALUES (?, ?, ?, ?, ?, ?)";
    $log_stmt = $conn->prepare($log_sql);
    if (!$log_stmt) {
        throw new PDOException("Insert prepare failed: " . implode(", ", $conn->errorInfo()));
    }
    $log_stmt->bindParam(1, $row['first_name']);
    $log_stmt->bindParam(2, $row['last_name']);
    $log_stmt->bindParam(3, $row['entity_name']);
    $log_stmt->bindParam(4, $email);
    $log_stmt->bindParam(5, $row['role'], PDO::PARAM_INT);
    $log_stmt->bindParam(6, $logout_time);
    $log_stmt->execute();
    error_log("Logout log inserted for: $email");  // Log insert success
    $log_stmt->closeCursor();

    // Optional: Destroy session if it exists (for web context, though this is API)
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    session_destroy();

    echo json_encode(['success' => true, 'message' => 'Logout successful']);
    
    $stmt->closeCursor();
    $conn = null; // Close connection
} catch (PDOException $e) {
    error_log("PDO Error in logout: " . $e->getMessage() . " | Code: " . $e->getCode());
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);  // Temp: Include details (remove in prod)
}
?>