<?php
header('Content-Type: application/json');
include "DB_connection.php"; // Assumes $conn is a PDO instance

try {
    // Assuming this fetches all unique entities (adjust query as needed, e.g., for a specific table/column)
    $stmt = $conn->prepare("SELECT DISTINCT entity FROM register ORDER BY entity ASC");
    $stmt->execute();
    $entities = $stmt->fetchAll(PDO::FETCH_COLUMN); // Fetch as array of entity names
    $stmt = null; // Close statement

    echo json_encode($entities); // Outputs clean JSON array, e.g., ["Corp", "Individual"]

} catch (PDOException $e) {
    error_log("Error fetching entities: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([]); // Return empty array on error to avoid breaking client
}
?>