<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Adjust for security
// Database connection (replace with your credentials)
include "DB_connection.php";
$sql = "SELECT DISTINCT entity FROM `register` ORDER BY entity ASC";
$result = $conn->query($sql);

$entities = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $entities[] = $row['entity'];
    }
}
echo json_encode($entities);

$conn->close();
?>

