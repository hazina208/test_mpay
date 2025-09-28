

<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Adjust for security
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

$data = json_decode(file_get_contents('php://input'), true);
$entity = $data['entity'] ?? '';

// Database connection (replace with your credentials)
include("connection.php");

$conn = new mysqli($host, $dbuser, $dbpass, $db);
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed']));
}

$stmt = $conn->prepare("SELECT DISTINCT entity_name FROM `register` WHERE entity = ? ORDER BY entity_name ASC");
$stmt->bind_param("s", $entity);
$stmt->execute();
$result = $stmt->get_result();

$entityNames = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $entityNames[] = $row['entity_name'];
    }
}
echo json_encode($entityNames);

$stmt->close();
$conn->close();
?>