
<?php
include "DB_connection.php";

$county = $_GET['county'] ?? '';

if ($county != '') {
    $stmt = $conn->prepare("SELECT county_code FROM counties WHERE county = ?");
    $stmt->bind_param("s", $county);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    echo json_encode($result);
}
?>