<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Adjust for security in production
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
$data = json_decode(file_get_contents('php://input'), true);
$entity = $data['entity'] ?? '';

// Early exit if no entity provided
if (empty($entity)) {
    echo json_encode([]);
    exit;
}

include "DB_connection.php"; // Assumes $conn is a PDO instance

try {
    $stmt = $conn->prepare("SELECT DISTINCT entity_name FROM `register` WHERE entity = ? ORDER BY entity_name ASC");
    $stmt->execute([$entity]);
    $entityNames = $stmt->fetchAll(PDO::FETCH_COLUMN); // Fetch as array of entity_name values
    $stmt = null; // Close statement

    echo json_encode($entityNames); // Outputs clean JSON array, e.g., ["MyCorp", "YourInc"]

} catch (PDOException $e) {
    error_log("Error fetching entity names: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([]); // Return empty array on error to avoid breaking client
}
?>