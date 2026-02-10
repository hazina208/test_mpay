<?php
require_once '../../DB_connection.php';
require_once 'auth.php';
require_once 'config.php';
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}
//header('Content-Type: application/json');
if (!$conn) {
    die(json_encode(['message' => 'DB Connection failed']));
}

$data = json_decode(file_get_contents('php://input'), true) ?? $_POST;
// Required fields
$required = ['amount', 'recipient_account', 'sender_account', 'recipient_name'];
foreach ($required as $field) {
    if (empty($data[$field])) {
        http_response_code(400);
        echo json_encode(['error' => "Missing required field: $field"]);
        exit;
    }
}

$amount = mysqli_real_escape_string($conn, $data['amount']);
$recipient_account = mysqli_real_escape_string($conn, $data['recipient_account']);
$sender_account = mysqli_real_escape_string($conn, $data['sender_account']); // For logging, not used in payout
$recipient_name = mysqli_real_escape_string($conn, $data['recipient_name']);
// Assume user_id from auth (e.g., JWT or session); hardcoded for example
$email = $data['email'] ?? '';  
$branch_id = isset($data['branch_id']) ? (int)$data['branch_id'] : null;
// Validation
if ($amount <= 0 || $amount > 999999) {
    echo json_encode(['error' => 'Invalid amount']);
    exit;
}

// Get or create user in banktobankusers (since it has phone, email, stats)
$userStmt = $conn->prepare("SELECT user_id, email, branch_id FROM banktobankusers WHERE email = ?");
$userStmt->execute([$email]);
$user = $userStmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    $user_id = $user['user_id'];
    $user_email = $user['email'];
    $branch_id = $user['branch_id'] ?? $branch_id; 
} else {
    // Create in users (link to register if email matches)
    $regStmt = $conn->prepare("SELECT id, branch_id FROM register WHERE email = ?");
    $regStmt->execute([$email]);
    $reg = $regStmt->fetch(PDO::FETCH_ASSOC);
    $reg_id = $reg ? $reg['id'] : null;
    $branch_id = $reg ? $reg['branch_id'] : $branch_id;

    $insert = $conn->prepare("
        INSERT INTO banktobankusers (user_id, branch_id, email, credit_score, total_transactions, total_amount)
        VALUES (?, ?, ?, ?, 300, 0, 0) 
    ");
    $insert->execute([$reg_id, $branch_id, $email]);
    $user_id = $reg_id ?? $conn->lastInsertId(); 
    $user_email = $email;
}
// If no branch_id at all → error or default
if ($branch_id === null) {
    echo json_encode(['error' => 'No branch selected. Please contact support or log in again.']);
    exit;
}
// Insert transaction
$sql = "INSERT INTO cargo_pay_bank_bank (user_id, branch_id, email, amount, recipient_account, sender_account, recipient_name) VALUES ($user_id, $branch_id, $user_email, $amount, '$recipient_account', '$sender_account', '$recipient_name')";
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
        mysqli_query($conn, "UPDATE cargo_pay_bank_bank SET transaction_id = '$tracking_id' WHERE id = $local_tx_id");
        echo json_encode(['message' => 'Payment initiated', 'tracking_id' => $tracking_id]);
    } else {
        // Handle error
        mysqli_query($conn, "UPDATE cargo_pay_bank_bank SET status = 'FAILED' WHERE id = $local_tx_id");
        echo json_encode(['message' => 'IntaSend error: ' . $response]);
    }
} else {
    echo json_encode(['message' => 'DB error']);
}

mysqli_close($conn);
