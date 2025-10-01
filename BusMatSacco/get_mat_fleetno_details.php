
<?php
include "DB_connection.php";

$sacco = $_GET['sacco'] ?? '';

if ($sacco != '') {
    $stmt = $conn->prepare("SELECT fleet_no FROM fleet_no WHERE sacco = ?");
    $stmt->bind_param("s", $sacco);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    echo json_encode($result);
}
?>


<?php
header('Content-Type: application/json');
include "../DB_connection.php";

$sacco = $_GET['sacco'] ?? '';

if (!empty($sacco)) {
    try {
        $stmt = $conn->prepare("SELECT fleet_no FROM fleet_no WHERE sacco = ?");
        $stmt->execute([$sacco]);
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