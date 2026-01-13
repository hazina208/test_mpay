<?php
header("Content-Type: application/json");
include("../../DB_connection.php");

if (isset($_GET['bank_name'])) {
    $bank_name = $_GET['bank_name'];
    
    try {
        $stmt = $conn->prepare("SELECT bank_code FROM banks WHERE bank_name = ?");
        $stmt->execute([$bank_name]);
        $bank_code = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all rows as assoc arrays
        $stmt = null; // Close statement
        
        echo json_encode($bank_code);
    } catch (PDOException $e) {
        error_log("Error fetching Bank Codes: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(["error" => "Database error occurred"]);
    }
} else {
    echo json_encode(["error" => "Bank Name not provided"]);
}
?>
