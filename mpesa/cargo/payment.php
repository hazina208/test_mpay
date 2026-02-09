<?php
require_once '../../DB_connection.php';
require_once 'auth.php';
require_once 'config.php';
header('Content-Type: application/json');

if (!$conn) {
    die(json_encode(['message' => 'DB Connection failed']));
}

$data = json_decode(file_get_contents('php://input'), true);
$amount = mysqli_real_escape_string($conn, $data['amount']);
$recipient_account = mysqli_real_escape_string($conn, $data['recipient_account']);
$sender_account = mysqli_real_escape_string($conn, $data['sender_account']); // For logging, not used in payout
$recipient_name = mysqli_real_escape_string($conn, $data['recipient_name']);
// Assume user_id from auth (e.g., JWT or session); hardcoded for example
$user_id = 1;

// Insert transaction
$sql = "INSERT INTO transactions (user_id, amount, recipient_account, sender_account, recipient_name) VALUES ($user_id, $amount, '$recipient_account', '$sender_account', '$recipient_name')";
if (mysqli_query($conn, $sql)) {
    $local_tx_id = mysqli_insert_id($conn);

    // Initiate IntaSend payout (example for bank; adjust provider/bank_code as needed)
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => INTASEND_API_URL . '/api/v1/send-money/initiate/',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer ' . INTASEND_BEARER_TOKEN,
            'Content-Type: application/json'
        ),
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode(array(
            'provider' => 'BANK', // Or 'MPESA-B2C' for mobile
            'currency' => 'KES', // Adjust for international (e.g., 'USD' if supported)
            'transactions' => array(
                array(
                    'narrative' => 'Payment to ' . $recipient_name,
                    'name' => $recipient_name,
                    'account' => $recipient_account,
                    'bank_code' => '63', // Example Kenyan bank code; lookup in IntaSend docs
                    'amount' => $amount
                )
            )
        ))
    ));
    $response = curl_exec($curl);
    curl_close($curl);

    $resp_data = json_decode($response, true);
    if (isset($resp_data['tracking_id'])) {
        // Update local tx with IntaSend ID
        $tracking_id = $resp_data['tracking_id'];
        mysqli_query($conn, "UPDATE transactions SET transaction_id = '$tracking_id' WHERE id = $local_tx_id");
        echo json_encode(['message' => 'Payment initiated', 'tracking_id' => $tracking_id]);
    } else {
        // Handle error
        mysqli_query($conn, "UPDATE transactions SET status = 'FAILED' WHERE id = $local_tx_id");
        echo json_encode(['message' => 'IntaSend error: ' . $response]);
    }
} else {
    echo json_encode(['message' => 'DB error']);
}

mysqli_close($conn);
