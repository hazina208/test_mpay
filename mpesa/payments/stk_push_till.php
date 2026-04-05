<?php
// === ABSOLUTE FIRST LINE - NO whitespace, no blank lines, no BOM above this ===

ob_start();
ini_set('display_errors', 0);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

// Clean any early output
if (ob_get_length() > 0) ob_clean();

// Early debug - will help us see if script even starts
echo json_encode(['debug' => 'PHP script started successfully']);
if (ob_get_length() > 0) ob_clean();  // remove the debug if we reach real code

// ====================== ERROR HANDLERS ======================
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    if (ob_get_length() > 0) ob_clean();
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => "PHP Error: $errstr in $errfile line $errline"
    ]);
    exit;
});

set_exception_handler(function($e) {
    if (ob_get_length() > 0) ob_clean();
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Exception: ' . $e->getMessage() . 
                     ' (' . $e->getFile() . ':' . $e->getLine() . ')'
    ]);
    exit;
});

try {
    // Check required files
    if (!file_exists('config.php')) {
        throw new Exception('config.php not found');
    }
    if (!file_exists('../../DB_connection.php')) {
        throw new Exception('../../DB_connection.php not found - check path');
    }

    require_once 'config.php';
    require_once 'auth.php';
    include '../../DB_connection.php';

    // Critical: Composer autoloader
    $autoloader = __DIR__ . '/vendor/autoload.php';
    if (!file_exists($autoloader)) {
        throw new Exception('vendor/autoload.php not found. Run "composer install" on Render.');
    }
    require $autoloader;

    use Endroid\QrCode\QrCode;
    use Endroid\QrCode\Writer\PngWriter;

    // Now read input
    $rawInput = file_get_contents('php://input');
    if (empty($rawInput)) {
        throw new Exception('Empty input received');
    }

    $input = json_decode($rawInput, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Invalid JSON: ' . json_last_error_msg());
    }

    $till   = trim($input['till_number'] ?? '');
    $amount = floatval($input['amount'] ?? 0);
    $phone  = trim($input['phone_number'] ?? '');

    if (empty($till) || $amount < 1 || empty($phone)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
        exit;
    }

    // Phone formatting
    if (preg_match('/^0[17]\d{8}$/', $phone)) {
        $phone = '254' . substr($phone, 1);
    } elseif (!preg_match('/^254[17]\d{8}$/', $phone)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid phone number']);
        exit;
    }

    $reference = 'TILL-' . strtoupper(substr(md5(uniqid()), 0, 12));

    function calculateFee($amount) {
        if ($amount >= 1 && $amount <= 50.99) return ceil($amount * 0.002);
        if ($amount >= 51 && $amount <= 80.99) return ceil($amount * 0.005);
        if ($amount >= 81 && $amount <= 100.99) return ceil($amount * 0.009);
        if ($amount >= 101 && $amount <= 150.99) return ceil($amount * 0.01);
        if ($amount >= 151 && $amount <= 400.99) return ceil($amount * 0.018);
        if ($amount >= 401 && $amount <= 800.99) return ceil($amount * 0.02);
        if ($amount >= 801 && $amount <= 1200.99) return ceil($amount * 0.03);
        if ($amount >= 1201 && $amount <= 3000.99) return ceil($amount * 0.05);
        return 0;
    }

    $fee = calculateFee($amount);
    $total = $amount - $fee;

    $qr_text = "Till Number: $till\nAmount: KSh " . number_format($amount, 2) . "\nRef: $reference";

    $qr_dir = __DIR__ . '/qr_images/';
    if (!is_dir($qr_dir)) {
        if (!mkdir($qr_dir, 0755, true)) {
            throw new Exception('Failed to create qr_images directory');
        }
    }

    $qr_filename = $reference . '.png';
    $qr_path = $qr_dir . $qr_filename;
    $qr_url_path = 'qr_images/' . $qr_filename;

    // QR Code
    $qrCode = QrCode::create($qr_text)->setSize(300)->setMargin(10);
    $writer = new PngWriter();
    $result = $writer->write($qrCode);
    $result->saveToFile($qr_path);

    // Database insert
    if (!isset($conn)) {
        throw new Exception('$conn is not defined - check DB_connection.php');
    }

    $stmt = $conn->prepare("INSERT INTO till_payments 
        (till_number, amount, fee, total, payer_phone, reference, qr_text, qr_image_path, status) 
        VALUES (?,?,?,?,?,?,?,?, 'pending')");

    $stmt->execute([$till, $amount, $fee, $total, $phone, $reference, $qr_text, $qr_url_path]);

    // Success
    echo json_encode([
        'success' => true,
        'reference' => $reference,
        'till' => $till,
        'amount' => $amount,
        'fee' => $fee,
        'total' => $total,
        'phone' => $phone,
        'qr_text' => $qr_text,
        'qr_image_path' => $qr_url_path,
        'message' => 'QR Code generated successfully'
    ]);

} catch (Throwable $e) {
    if (ob_get_length() > 0) ob_clean();
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} finally {
    if (ob_get_length() > 0) ob_end_flush();
}
?>
