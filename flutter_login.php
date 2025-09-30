<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

// Database connection
include "DB_connection.php";

try {
    // Find user by email or phone
    $stmt = $conn->prepare("SELECT password FROM register WHERE email = ? OR phone = ?");
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

    if (password_verify($data['password'], $row['password'])) {
        echo json_encode(['success' => true]);
        // Uncomment and adjust the log insertion code if needed
        /*
        $log_sql = "INSERT INTO logs (first_name, last_name, entity_name, email, password, role) VALUES (?, ?, ?, ?, ?, ?)";
        $log_stmt = $conn->prepare($log_sql);
        $log_stmt->bindParam(1, $fn);
        $log_stmt->bindParam(2, $ln);
        $log_stmt->bindParam(3, $co);
        $log_stmt->bindParam(4, $email);
        $log_stmt->bindParam(5, $pwd);
        $log_stmt->bindParam(6, $role);
        $log_stmt->execute();
        $log_stmt->closeCursor();
        */
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