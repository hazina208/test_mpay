<?php
include "../DB_connection.php";

$sacco = $_GET['sacco'] ?? '';

if ($sacco != '') {
    $stmt = $conn->prepare("SELECT fleet_no FROM lorry_fleet_no WHERE sacco = ?");
    $stmt->bind_param("s", $sacco);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    echo json_encode($result);
}
?>