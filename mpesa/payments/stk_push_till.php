<?php
// === MUST BE FIRST LINE (NO SPACES BEFORE THIS) ===
ob_start();
ini_set('display_errors', 0);
error_reporting(E_ALL);
header('Content-Type: application/json; charset=utf-8');

if (ob_get_length() > 0) ob_clean();

// ✅ MUST BE AT TOP LEVEL (OUTSIDE try)
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

// ================= ERROR HANDLERS =================
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    if (ob_get_length() > 0) ob_clean();
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => "PHP Error: $errstr in $errfile on line $errline"
    ]);
    exit;
});

set_exception_handler(function($e) {
    if (ob_get_length() > 0) ob_clean();
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Exception: ' . $e->getMessage()
    ]);
    exit;
});

try {

    // ================= DEPENDENCIES =================
    if (!file_exists(__DIR__ . '/../../vendor/autoload.php')) {
        throw new Exception('vendor/autoload.php not found. Run composer install.');
    }

    require_once __DIR__ . '/../../vendor/autoload.php';
    require_once 'config.php';
    require_once 'auth.php';
    require_once '../../DB_connection.php';

    // ================= INPUT =================
    $rawInput = file_get_contents('php://input');
    $input = json_decode($rawInput, true);

    if (!$input) {
        throw new Exception('Invalid JSON input');
    }

    $till   = trim($input['till_number'] ?? '');
    $amount = floatval($input['amount'] ?? 0);
    $phone  = trim($input['phone_number'] ?? '');

    if (!$till || $amount <= 0 || !$phone) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'All fields are required'
        ]);
        exit;
    }

    // ================= PHONE FORMAT =================
    if (preg_match('/^0[17]\d{8}$/', $phone)) {
        $phone = '254' . substr($phone, 1);
    } elseif (!preg_match('/^254[17]\d{8}$/', $phone)) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Invalid phone number'
        ]);
        exit;
    }

    // ================= BUSINESS LOGIC =================
    $reference = 'TILL-' . strtoupper(substr(md5(uniqid()), 0, 10));

    function calculateFee($amount) {
        if ($amount <= 50) return ceil($amount * 0.002);
        if ($amount <= 80) return ceil($amount * 0.005);
        if ($amount <= 100) return ceil($amount * 0.009);
        if ($amount <= 150) return ceil($amount * 0.01);
        if ($amount <= 400) return ceil($amount * 0.018);
        if ($amount <= 800) return ceil($amount * 0.02);
        if ($amount <= 1200) return ceil($amount * 0.03);
        if ($amount <= 3000) return ceil($amount * 0.05);
        return ceil($amount * 0.06);
    }

    $fee = calculateFee($amount);
    $total = $amount - $fee;

    // ================= QR GENERATION =================
    $qr_text = "Till: $till\nAmount: KES $amount\nRef: $reference";

    $qr_dir = __DIR__ . '/../../qr_images/';
    if (!is_dir($qr_dir)) {
        mkdir($qr_dir, 0755, true);
    }

    $qr_filename = $reference . '.png';
    //$qr_path = $qr_dir . $qr_filename;
    $qr_url_path = 'qr_images/' . $qr_filename;
    

    $qrCode = QrCode::create($qr_text)->setSize(300);
    $writer = new PngWriter();
    $writer->write($qrCode)->saveToFile($qr_url_path);

    // ================= DATABASE =================
    if (!isset($conn)) {
        throw new Exception('Database connection not available');
    }

    $stmt = $conn->prepare("INSERT INTO till_payments 
        (till_number, amount, fee, total, payer_phone, reference, qr_text, qr_image_path, status)
        VALUES (?,?,?,?,?,?,?,?, 'pending')");

    $stmt->execute([
        $till,
        $amount,
        $fee,
        $total,
        $phone,
        $reference,
        $qr_text,
        'qr_images/' . $qr_filename
    ]);

    // ================= SUCCESS RESPONSE =================
    echo json_encode([
        'success' => true,
        'reference' => $reference,
        'till' => $till,
        'amount' => $amount,
        'fee' => $fee,
        'total' => $total,
        'phone' => $phone,
        'qr_image' => 'qr_images/' . $qr_filename,
        'message' => 'QR Code generated successfully'
    ]);

} catch (Throwable $e) {

    if (ob_get_length() > 0) ob_clean();

    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
