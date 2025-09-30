<?php

// Database configuration from Render environment variables
define('DB_HOST', getenv('DB_HOST'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASS', getenv('DB_PASS'));
define('DB_NAME', getenv('DB_NAME'));
define('DB_PORT', getenv('DB_PORT'));
// Mpesa constants (you can also move these into env vars for security!)
define('MPESA_CONSUMER_KEY', getenv('uEWApsgB5NFs9FiedApURKPVDzB3fOzBlFyDwMxG7AdA26YM'));
define('MPESA_CONSUMER_SECRET', getenv('KiItsROrqWTmygwnHAZA6QpJuzCHvWz2S8QV2nUZIheG3bJJXThjNSgW8X2ZSBAv'));
define('MPESA_PASSKEY', getenv('KiItsROrqWTmygwnHAZA6QpJuzCHvWz2S8QV2nUZIheG3bJJXThjNSgW8X2ZSBAv'));
define('MPESA_SHORTCODE', getenv('174379'));
define('MPESA_CALLBACK_URL4', getenv('https://test_mpay.onrender.com/m_pay/mpesa/insurance/callback.php'));
define('MPESA_ENV', getenv('MPESA_ENV') ?: 'sandbox'); // default sandbox

// Database connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
