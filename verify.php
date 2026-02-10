<?php
ob_start(); // Buffer output to prevent "headers already sent" issues
// session_start(); // Uncomment if you need session-based authentication later

require_once 'mpesa/cargo/config.php'; // Assuming this defines INTASEND_API_URL, INTASEND_BEARER_TOKEN, etc.
header('Content-Type: application/json');

// Include your DB connection (you mentioned PDO, but code uses mysqli → adjust if needed)
include "DB_connection.php"; // This should define $conn as mysqli connection

// Read JSON input from Flutter / frontend
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['tracking_id']) || empty($data['tracking_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing or invalid tracking_id']);
    exit;
}

$tracking_id = mysqli_real_escape_string($conn, $data['tracking_id']);

// Option 1: Prefer real-time poll from IntaSend API (recommended for verification)
// Option 2: You could fallback to DB if you trust webhooks completely

// Poll IntaSend or check DB (webhooks keep DB updated)
// Here we poll IntaSend directly for fresh status
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => INTASEND_API_URL . '/api/v1/send-money/status/',  // Adjust if exact path differs (check your dashboard/docs)
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode(array(
        'tracking_id' => $tracking_id
    )),
    CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer ' . INTASEND_BEARER_TOKEN,
        'Content-Type: application/json'
    ),
));

$response = curl_exec($curl);
$http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
$curl_error = curl_error($curl);
curl_close($curl);

// ... (fetch remote status)
if ($curl_error) {
    // CURL failed (network issue, timeout, etc.)
    http_response_code(500);
    echo json_encode([
        'error' => 'CURL error: ' . $curl_error,
        'status' => 'UNKNOWN'
    ]);
    exit;
}

if ($http_code !== 200) {
    http_response_code($http_code);
    echo json_encode([
        'error' => 'IntaSend API returned non-200 status: ' . $http_code,
        'raw_response' => $response,
        'status' => 'UNKNOWN'
    ]);
    exit;
}

$resp_data = json_decode($response, true);

// Extract status — IntaSend uses fields like "status", "state", "transaction_status"
// Common values: PENDING, PROCESSING, COMPLETED, FAILED, etc.
// Adjust key based on actual response (check IntaSend docs or log $response during testing)
$remote_status = strtoupper($resp_data['status'] ?? $resp_data['state'] ?? 'UNKNOWN');

// Optional: Update your local DB with this fresh status (for reconciliation / trust)
$update_sql = "UPDATE cargo_pay_bank_bank SET status = '$remote_status' 
               WHERE transaction_id = '$tracking_id' 
               LIMIT 1";
mysqli_query($conn, $update_sql); // Silent update — you can check errors if needed

// Return the status to the frontend (Flutter app)
echo json_encode([
    'status' => $remote_status,
    'details' => $resp_data // Optional: send full response for debugging / display
]);

mysqli_close($conn);
?>
