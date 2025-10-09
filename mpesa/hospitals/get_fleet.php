<?php
header("Content-Type: application/json");
include("../../DB_connection.php");

if (isset($_GET['sacco'])) {
    $sacco = $_GET['sacco'];
    
    try {
        $stmt = $conn->prepare("SELECT fleet_no FROM fleet_no WHERE sacco = ?");
        $stmt->execute([$sacco]);
        $fleets = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all rows as assoc arrays
        $stmt = null; // Close statement
        
        echo json_encode($fleets);
    } catch (PDOException $e) {
        error_log("Error fetching fleets: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(["error" => "Database error occurred"]);
    }
} else {
    echo json_encode(["error" => "Sacco not provided"]);
}
?>
