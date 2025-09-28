
<?php
include("../connection.php");

$county = $_GET['county'] ?? '';

if ($county != '') {
    $stmt = $conn->prepare("SELECT countycode, sub_county FROM sub_counties WHERE county = ?");
    $stmt->bind_param("s", $county);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    echo json_encode($result);
}
?>