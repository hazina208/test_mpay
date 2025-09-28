<?php
include("../connection.php");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

header("Content-Type: application/json");

if (isset($_GET['sacco'])) {
    $sacco = $_GET['sacco'];

    $stmt = $conn->prepare("SELECT fleet_no FROM fleet_no WHERE sacco = ?");
    $stmt->bind_param("s", $sacco);
    $stmt->execute();
    $result = $stmt->get_result();

    $fleets = [];
    while ($row = $result->fetch_assoc()) {
        $fleets[] = $row;
    }

    echo json_encode($fleets);
} else {
    echo json_encode(["error" => "Sacco not provided"]);
}

$conn->close();
?>
