<?php
header('Content-Type: application/json');
include "../DB_connection.php";

$county = $_GET['county'] ?? '';

if (!empty($county)) {
    try {
        $stmt = $conn->prepare("SELECT county_code FROM counties WHERE county = ?");
        $stmt->execute([$county]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt = null; // Close statement
        echo json_encode($result ?: []); // Return assoc array or empty if no row
    } catch (PDOException $e) {
        error_log("Error fetching fleet no: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['error' => 'Database error occurred']);
    }
} else {
    echo json_encode([]); // Empty if no sacco param
}
?>