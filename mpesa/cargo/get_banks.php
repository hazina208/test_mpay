<?php
header("Content-Type: application/json");
include("../../DB_connection.php");

try {
    if (isset($_GET['bank_name'])) {
        $bank_name = $_GET['bank_name'];
        $stmt = $conn->prepare("SELECT bank_code, bank_name FROM banks WHERE bank_name = ?");
        $stmt->execute([$bank_name]);
    } else {
        // Fetch all banks if no specific name provided
        $stmt = $conn->prepare("SELECT bank_code, bank_name FROM banks");
        $stmt->execute();
    }
    
    $banks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt = null;
    
    echo json_encode($banks);
} catch (PDOException $e) {
    error_log("Error fetching Banks: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(["error" => "Database error occurred"]);
}
?>
