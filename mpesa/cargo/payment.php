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

if (!$conn) {
    http_response_code(500);
    echo json_encode(['message' => 'DB Connection failed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON: ' . json_last_error_msg()]);
    exit;
}

// Required fields
$required = ['amount', 'recipient_account', 'sender_account', 'recipient_name', 'bank_code'];
foreach ($required as $field) {
    if (!isset($data[$field]) || trim($data[$field]) === '') {
        http_response_code(400);
        echo json_encode(['error' => "Missing or empty required field: $field"]);
        exit;
    }
}

$amount           = $data['amount'];
$recipient_account = $data['recipient_account'];
$sender_account    = $data['sender_account'];
$recipient_name    = $data['recipient_name'];
$bank_code         = trim($data['bank_code'] ?? '');
$email            = $data['email'] ?? '';
$branch_id        = isset($data['branch_id']) ? (int)$data['branch_id'] : null;

// Server-side amount validation
if (!is_numeric($amount) || $amount <= 0 || $amount > 999999) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid amount']);
    exit;
}

try {
    // 1. Get or create user in banktobankusers
    $userStmt = $conn->prepare("SELECT user_id, email, branch_id FROM banktobankusers WHERE email = ?");
    $userStmt->execute([$email]);
    $user = $userStmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $user_id     = $user['user_id'];
        $user_email  = $user['email'];
        $branch_id   = $user['branch_id'] ?? $branch_id;
    } else {
        // Link to register table if possible
        $regStmt = $conn->prepare("SELECT id, branch_id FROM register WHERE email = ?");
        $regStmt->execute([$email]);
        $reg = $regStmt->fetch(PDO::FETCH_ASSOC);

        $reg_id    = $reg ? $reg['id'] : null;
        $branch_id = $reg ? $reg['branch_id'] : $branch_id;

        $insert = $conn->prepare("
            INSERT INTO banktobankusers 
            (user_id, branch_id, email, credit_score, total_transactions, total_amount)
            VALUES (?, ?, ?, 300, 0, 0)
        ");
        $insert->execute([$reg_id, $branch_id, $email]);

        $user_id    = $reg_id ?? $conn->lastInsertId();
        $user_email = $email;
    }

    // Mandatory branch_id check
    if ($branch_id === null) {
        http_response_code(400);
        echo json_encode(['error' => 'No branch selected. Please contact support or log in again.']);
        exit;
    }

    // 2. Insert transaction (using prepared statement → safe, no injection risk)
    $insertTx = $conn->prepare("
        INSERT INTO cargo_pay_bank_bank 
        (user_id, branch_id, email, amount, recipient_account, receipient_bank_code, sender_account, recipient_name, status)
        VALUES (:user_id, :branch_id, :email, :amount, :recipient_account, :bank_code, :sender_account, :recipient_name, 'PENDING')
    ");

    $insertTx->execute([
        ':user_id'          => $user_id,
        ':branch_id'        => $branch_id,
        ':email'            => $user_email,
        ':amount'           => $amount,
        ':recipient_account' => $recipient_account,
        ':bank_code'         => $bank_code,
        ':sender_account'    => $sender_account,
        ':recipient_name'    => $recipient_name,
    ]);

    $local_tx_id = $conn->lastInsertId();

    // 3. Initiate IntaSend payout
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL            => INTASEND_SANDBOX_API_URL . '/api/v1/send-money/initiate/',
        //CURLOPT_URL            => INTASEND_API_URL . '/api/v1/send-money/initiate/',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER     => [
            'Authorization: Bearer ' . INTASEND_BEARER_TOKEN,
            'Content-Type: application/json'
        ],
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => json_encode([
            'provider'     => 'PESALINK',
            'currency'     => 'KES',
            'transactions' => [
                [
                    'narrative' => 'Payment to ' . $recipient_name,
                    'name'      => $recipient_name,
                    'account'   => $recipient_account,
                    'bank_code' => $bank_code,
                    'amount'    => (float)$amount
                ]
            ]
        ])
    ]);

    $response   = curl_exec($curl);
    $curl_error = curl_error($curl);
    curl_close($curl);

    if ($curl_error) {
        // Rollback status on cURL failure
        $conn->prepare("UPDATE cargo_pay_bank_bank SET status = 'FAILED' WHERE id = ?")
             ->execute([$local_tx_id]);
        http_response_code(500);
        echo json_encode(['message' => 'cURL error contacting IntaSend: ' . $curl_error]);
        exit;
    }

    $resp_data = json_decode($response, true);

    if (isset($resp_data['tracking_id'])) {
        $tracking_id = $resp_data['tracking_id'];

        // Update with tracking ID
        $update = $conn->prepare("
            UPDATE cargo_pay_bank_bank 
            SET transaction_id = :tracking_id, status = 'INITIATED' 
            WHERE id = :id
        ");
        $update->execute([':tracking_id' => $tracking_id, ':id' => $local_tx_id]);

        echo json_encode([
            'message'     => 'Payment initiated',
            'tracking_id' => $tracking_id
        ]);
    } else {
        // Mark as failed
        $conn->prepare("UPDATE cargo_pay_bank_bank SET status = 'FAILED' WHERE id = ?")
             ->execute([$local_tx_id]);

        http_response_code(500);
        echo json_encode([
            'message'  => 'IntaSend initiation failed',
            'details'  => $resp_data ?? $response  // return raw for debug
        ]);
    }

} catch (PDOException $e) {
    error_log("Payment PHP error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['message' => 'Database error: ' . $e->getMessage()]);
}

$conn = null; // Close PDO connection
