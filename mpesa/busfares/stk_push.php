<?php
require_once 'config.php';
require_once 'auth.php';

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$sacco = $input['sacco'] ?? '';
$amount = $input['amount'] ?? 0;
$fleet_no = $input['fleet_no'] ?? '';
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
$total = ceil($amount + $fee);  // Ceil to integer for M-Pesa (adjust rounding if needed)
$fee = $total - $amount;  // Update fee to match the ceiled total

// Save payment details to database
$stmt = $conn->prepare("INSERT INTO bus_fares (sacco, amount, fee, total, fleet_no, phone_number,status) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sdddsss", $sacco, $amount, $fee, $total, $fleet_no, $phone_number, $status);
$stmt->execute();
$payment_id = $conn->insert_id;
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
    'Amount' => $amount,
    'PartyA' => $phone_number,
    'PartyB' => MPESA_SHORTCODE,
    'PhoneNumber' => $phone_number,
    'CallBackURL' => MPESA_CALLBACK_URL,
    'AccountReference' => 'BusFare_' . $payment_id,
    'TransactionDesc' => 'Payment for ' . $sacco . ' - Fleet: ' . $fleet_no
];

//$headers = [
    //'Authorization: Bearer ' . $access_token,
    //'Content-Type: application/json'
//];

//$ch = curl_init($url);
//curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//curl_setopt($ch, CURLOPT_POST, true);
//curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//$response = curl_exec($ch);
//curl_close($ch);
//
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Authorization: Bearer ' . $access_token]);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));
$response = json_decode(curl_exec($curl));

//$response = json_decode($response, true);
//if (isset($response['ResponseCode']) && $response['ResponseCode'] == '0') {  
if (isset($response->ResponseCode) && $response->ResponseCode == 0) {
    // Save payment details to database
    $stmt2 = $conn->prepare("UPDATE bus_fares SET transaction_date=?, CheckoutRequestID =?, merchant_request_id =? WHERE id = (SELECT MAX(id) FROM bus_fares)");
    $stmt2->bind_param("sss", $timestamp, $response->CheckoutRequestID, $response->MerchantRequestID);
    $stmt2->execute();
    $stmt2->close();
    
    echo json_encode(['status' => true, 'message' => 'STK Push initiated. Please check your phone.']);
    

} else {
    echo json_encode(['status' => false, 'message' => 'STK Push failed: ' . ($response['errorMessage'] ?? 'Unknown error')]);
}


?>



<?php
require_once 'config.php';
require_once 'auth.php';
include '../../DB_connection.php'; // Use PDO connection
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$sacco = $input['sacco'] ?? '';
$amount = $input['amount'] ?? 0;
$fleet_no = $input['fleet_no'] ?? '';
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
$total = ceil($amount + $fee);  // Ceil to integer for M-Pesa (adjust rounding if needed)
$fee = $total - $amount;  // Update fee to match the ceiled total
$status = 'Pending';  // Define initial status

try {
    // Save payment details to database
    $stmt = $conn->prepare("INSERT INTO bus_fares (sacco, amount, fee, total, fleet_no, phone_number, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$sacco, $amount, $fee, $total, $fleet_no, $phone_number, $status]);
    $payment_id = $conn->lastInsertId();
    $stmt = null; // Close statement
} catch (PDOException $e) {
    error_log("Error inserting payment: " . $e->getMessage());
    echo json_encode(['status' => false, 'message' => 'Database error occurred']);
    exit;
}

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
    'Amount' => $total,  // Charge the total (amount + fee)
    'PartyA' => $phone_number,
    'PartyB' => MPESA_SHORTCODE,
    'PhoneNumber' => $phone_number,
    'CallBackURL' => MPESA_CALLBACK_URL,
    'AccountReference' => 'BusFare_' . $payment_id,
    'TransactionDesc' => 'Payment for ' . $sacco . ' - Fleet: ' . $fleet_no
];

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Authorization: Bearer ' . $access_token]);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));
$response_str = curl_exec($curl);
curl_close($curl);

$response = json_decode($response_str);

if (isset($response->ResponseCode) && $response->ResponseCode == 0) {
    try {
        // Save STK details to database
        $stmt2 = $conn->prepare("UPDATE bus_fares SET transaction_date = ?, CheckoutRequestID = ?, merchant_request_id = ? WHERE id = ?");
        $stmt2->execute([$timestamp, $response->CheckoutRequestID, $response->MerchantRequestID, $payment_id]);
        $stmt2 = null; // Close statement
        
        echo json_encode(['status' => true, 'message' => 'STK Push initiated. Please check your phone.']);
    } catch (PDOException $e) {
        error_log("Error updating payment: " . $e->getMessage());
        echo json_encode(['status' => false, 'message' => 'Database update failed']);
    }
} else {
    $error_msg = isset($response->errorMessage) ? $response->errorMessage : (isset($response['errorMessage']) ? $response['errorMessage'] : 'Unknown error');
    echo json_encode(['status' => false, 'message' => 'STK Push failed: ' . $error_msg]);
}
?>