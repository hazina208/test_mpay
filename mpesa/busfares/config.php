<?php
// Database configuration from Render environment variables
define('DB_HOST', getenv('DB_HOST'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASS', getenv('DB_PASS'));
define('DB_NAME', getenv('DB_NAME'));
define('DB_PORT', getenv('DB_PORT'));
// Mpesa constants (you can also move these into env vars for security!)
define('MPESA_CONSUMER_KEY', getenv('MPESA_CONSUMER_KEY'));
define('MPESA_CONSUMER_SECRET', getenv('MPESA_CONSUMER_SECRET'));
define('MPESA_PASSKEY', getenv('MPESA_PASSKEY'));
define('MPESA_SHORTCODE', getenv('MPESA_SHORTCODE'));
define('MPESA_CALLBACK_URL', getenv('MPESA_CALLBACK_URL'));
define('MPESA_ENV', getenv('MPESA_ENV') ?: 'sandbox'); // default sandbox

// Database connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

