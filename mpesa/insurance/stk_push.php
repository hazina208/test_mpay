<?php
require_once 'DB_connection.php';
require_once 'auth.php';
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$co = $input['sacco'] ?? '';
$member_no = $input['member_no'] ?? '';
$amount = $input['amount'] ?? 0;
$phone_number = $input['phone_number'] ?? '';

if (empty($sacco) || empty($amount) || empty($fleet_no) || empty($phone_number)) {
    echo json_encode(['status' => false, 'message' => 'Missing required fields']);
    exit;
}


// Function to calculate percentage fee
function calculateFee($amount) {
    if ($amount >= 1 && $amount <= 50.99) {
        return $amount * 0.002;  // 0.2%
    } elseif ($amount >= 51 && $amount <= 80.99) {
        return $amount * 0.005;  // 0.5%
    } elseif ($amount >= 81 && $amount <= 100.99) {
        return $amount * 0.009;  // 0.9%
    } elseif ($amount >= 101 && $amount <= 150.99) {
        return $amount * 0.01;  // 1%
    } elseif ($amount >= 151 && $amount <= 400.99) {
        return $amount * 0.018;   // 1.8%
    } elseif ($amount >= 401 && $amount <= 800.99) {
        return $amount * 0.02;  // 2%
    } elseif ($amount >= 501 && $amount <= 800.99) {
        return $amount * 0.025;  // 0.25%
    } elseif ($amount >= 801 && $amount <= 1200.99) {
        return $amount * 0.03;  // 0.3%
    } elseif ($amount >= 1201 && $amount <= 1500.99) {
        return $amount * 0.05;  // 0.5%
    } elseif ($amount >= 1501 && $amount <= 3000.99) {
        return $amount * 0.05;  // 0.5%
    } else {
        return 0;  // No fee for amounts outside ranges
    }
}

$fee = calculateFee($amount);
$total = ceil($amount + $fee);  // Ceil to integer for M-Pesa
$fee = $total - $amount;  // Update fee to match the ceiled total
$status = 'pending';  // Define status as pending

// Generate serial_no using PDO
$stmt_serial = $conn->prepare("SELECT serial_no FROM insurance_payments ORDER BY serial_no DESC LIMIT 1");
$stmt_serial->execute();
$row = $stmt_serial->fetch(PDO::FETCH_ASSOC);
$last_serial_no = $row ? $row['serial_no'] : null;

if ($last_serial_no == null) {
    $new_serial_no = "SRNO-0000001";
} else {
    $numeric_part = str_replace("SRNO-", "", $last_serial_no);
    $new_numeric = str_pad((int)$numeric_part + 1, 7, '0', STR_PAD_LEFT);
    $new_serial_no = "SRNO-" . $new_numeric;
}
$stmt_serial->close();

// Insert payment details to database
$stmt = $conn->prepare("INSERT INTO insurance_payments (serial_no, member_no, company, amount, fee, total,  phone_number,status) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bindParam(1, $new_serial_no, PDO::PARAM_STR);
$stmt->bindParam(2, $member_no, PDO::PARAM_STR);
$stmt->bindParam(3, $co, PDO::PARAM_STR);
$stmt->bindParam(4, $amount, PDO::PARAM_STR);  // Using STR for decimal amounts
$stmt->bindParam(5, $fee, PDO::PARAM_STR);
$stmt->bindParam(5, $total, PDO::PARAM_STR);
$stmt->bindParam(7, $phone_number, PDO::PARAM_STR);
$stmt->bindParam(8, $status, PDO::PARAM_STR);
$stmt->execute();
$payment_id = $conn->lastInsertId();
$stmt->close();

// Prepare STK Push
$access_token = getAccessToken();
if (!$access_token) {
    echo json_encode(['status' => false, 'message' => 'Failed to get access token']);
    exit;
}

$timestamp = date('YmdHis');
$password = base64_encode(MPESA_SHORTCODE . MPESA_PASSKEY . $timestamp);
$url = MPESA_ENV == 'sandbox'
    ? 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest'
    : 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

$payload = [
    'BusinessShortCode' => MPESA_SHORTCODE,
    'Password' => $password,
    'Timestamp' => $timestamp,
    'TransactionType' => 'CustomerPayBillOnline',
    'Amount' => $total,  // Use total amount including fee
    'PartyA' => $phone_number,
    'PartyB' => MPESA_SHORTCODE,
    'PhoneNumber' => $phone_number,
    'CallBackURL' => MPESA_CALLBACK_URL,
    'AccountReference' => 'PAY PREMIUMS_' . $payment_id,
    'TransactionDesc' => 'Payment for ' . $sacco
];

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $access_token
]);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));

$curl_response = curl_exec($curl);
if ($curl_response === false) {
    echo json_encode(['status' => false, 'message' => 'CURL request failed']);
    curl_close($curl);
    exit;
}

curl_close($curl);
$response = json_decode($curl_response);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['status' => false, 'message' => 'Invalid JSON response from M-Pesa']);
    exit;
}

if (isset($response->ResponseCode) && $response->ResponseCode == '0') {
    // Update payment details
    $stmt_update = $conn->prepare("UPDATE insurance_payments SET transaction_date = ?, CheckoutRequestID = ?, merchant_request_id = ? WHERE id = (SELECT MAX(id) FROM insurance_payments)");
    $stmt_update->bindParam(1, $timestamp, PDO::PARAM_STR);
    $stmt_update->bindParam(2, $response->CheckoutRequestID, PDO::PARAM_STR);
    $stmt_update->bindParam(3, $response->MerchantRequestID, PDO::PARAM_STR);
    $stmt_update->bindParam(4, $payment_id, PDO::PARAM_INT);
    $stmt_update->execute();
    $stmt_update->close();

    echo json_encode(['status' => true, 'message' => 'STK Push initiated. Please check your phone.']);
} else {
    $error_msg = isset($response->errorMessage) ? $response->errorMessage : 'Unknown error';
    echo json_encode(['status' => false, 'message' => 'STK Push failed: ' . $error_msg]);
}
?>