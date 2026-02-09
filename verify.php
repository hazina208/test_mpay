<?php
include '../config.php';

header('Content-Type: application/json');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$data = json_decode(file_get_contents('php://input'), true);
$tracking_id = mysqli_real_escape_string($conn, $data['tracking_id']);

// Poll IntaSend or check DB (webhooks keep DB updated)
$curl = curl_init(); // Similar to above for status
// ... (fetch remote status)

echo json_encode(['status' => $remote_status]); // Or from DB if trusted

mysqli_close($conn);
