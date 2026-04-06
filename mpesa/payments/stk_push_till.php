<?php
// === MUST BE THE VERY FIRST LINE - NO whitespace, no BOM, no echo before this ===
ob_start();
ini_set('display_errors', 0);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

if (ob_get_length() > 0) ob_clean();

// ====================== ERROR HANDLERS ======================
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
    // Load autoloader FIRST (before any use statements or other requires that might depend on it)
    if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
        throw new Exception('vendor/autoload.php not found. Run "composer install" on the server.');
    }
    require_once __DIR__ . '/vendor/autoload.php';

    // NOW the use statements are allowed
    use Endroid\QrCode\QrCode;
    use Endroid\QrCode\Writer\PngWriter;

    // Your other requires
    require_once 'config.php';
    require_once 'auth.php';
    include '../../DB_connection.php';

    // Rest of your code (input reading, validation, fee calculation, QR generation, DB insert, etc.)
    $rawInput = file_get_contents('php://input');
    $input = json_decode($rawInput, true);
    // ... (keep everything else exactly as you have it)

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
