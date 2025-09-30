
<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Adjust for security

// Database connection (replace with your credentials)
include "DB_connection.php";

$conn = new mysqli($host, $dbuser, $dbpass, $db);
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed']));
}

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

