<?php
include 'config.php';

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Find pending tx older than 24h
$sql = "SELECT * FROM transactions WHERE status = 'PENDING' AND created_at < NOW() - INTERVAL 24 HOUR";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    // Poll IntaSend status via CURL
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => INTASEND_API_URL . '/api/v1/send-money/status/',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer ' . INTASEND_BEARER_TOKEN,
            'Content-Type: application/json'
        ),
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode(array('tracking_id' => $row['transaction_id']))
    ));
    $response = curl_exec($curl);
    curl_close($curl);

    $resp_data = json_decode($response, true);
    $remote_status = strtoupper($resp_data['state'] ?? 'UNKNOWN');

    if ($remote_status != 'COMPLETED') {
        mysqli_query($conn, "UPDATE transactions SET status = 'DISCREPANT' WHERE id = {$row['id']}");
        // Notify user (e.g., email/SMS; implement via CURL to Twilio or similar)
        // Example: mail('user@email.com', 'Discrepancy', 'Tx ID: ' . $row['transaction_id']);
    } else {
        mysqli_query($conn, "UPDATE transactions SET status = 'COMPLETED' WHERE id = {$row['id']}");
    }
}

mysqli_close($conn);
