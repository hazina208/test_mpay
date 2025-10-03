<?php
session_start();
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

// Database connection
include "DB_connection.php";

try {
    // Find user by email or phone - select all necessary fields
    $stmt = $conn->prepare("SELECT id, email, phone, password, role, entity_name, first_name, last_name FROM register WHERE email = ? OR phone = ? LIMIT 1");
    $stmt->bindParam(1, $data['identifier']);
    $stmt->bindParam(2, $data['identifier']);
    $stmt->execute();
   
    // Fetch the result (single row expected)
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
        echo json_encode(['success' => false, 'message' => 'Incorrect identifier or password']);
        $stmt->closeCursor();
        $conn = null; // Close connection
        exit;
    }

    // Hash the input password using the referenced method
    $hashed_input_password = sha1(md5($data['password']));

    if ($hashed_input_password === $row['password']) {
        // Regenerate session ID for security
        session_regenerate_id(true);
        // Store session data
        $_SESSION['id'] = $row['id'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['entity_name'] = $row['entity_name'];
        $_SESSION['first_name'] = $row['first_name'];
        $_SESSION['last_name'] = $row['last_name'];
        
        // Log user activity (avoid logging password for security; adjust table if needed)
        $email = $row['email'];
        $pwd = $data['password']; // Note: Logging plain password is insecure; consider removing this field
        $log_sql = "INSERT INTO logs (first_name, last_name, entity_name, email, password, role) VALUES (?, ?, ?, ?, ?, ?)";
        $log_stmt = $conn->prepare($log_sql);
        $log_stmt->bindParam(1, $_SESSION['first_name']);
        $log_stmt->bindParam(2, $_SESSION['last_name']);
        $log_stmt->bindParam(3, $_SESSION['entity_name']);
        $log_stmt->bindParam(4, $email);
        $log_stmt->bindParam(5, $pwd);
        $log_stmt->bindParam(6, $_SESSION['role'], PDO::PARAM_INT);
        $log_stmt->execute();
        $log_stmt->closeCursor();
        
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Incorrect identifier or password']);
    }
    $stmt->closeCursor();
    $conn = null; // Close connection
} catch (PDOException $e) {
    error_log("Error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Database error']);
}
?>