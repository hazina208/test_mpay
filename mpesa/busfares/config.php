

<?php
// Database configuration from Render environment variables
define('DB_HOST', getenv('bg4ikv5j4exzavzvcmwb-mysql.services.clever-cloud.com'));
define('DB_USER', getenv('uo0yxrgvekb7yhnz'));
define('DB_PASS', getenv('lL6TCCUmkmY9oCsTEYsX'));
define('DB_NAME', getenv('bg4ikv5j4exzavzvcmwb'));
define('DB_PORT', getenv('3306'));
// Mpesa constants (you can also move these into env vars for security!)
define('MPESA_CONSUMER_KEY', getenv('uEWApsgB5NFs9FiedApURKPVDzB3fOzBlFyDwMxG7AdA26YM'));
define('MPESA_CONSUMER_SECRET', getenv('KiItsROrqWTmygwnHAZA6QpJuzCHvWz2S8QV2nUZIheG3bJJXThjNSgW8X2ZSBAv'));
define('MPESA_PASSKEY', getenv('KiItsROrqWTmygwnHAZA6QpJuzCHvWz2S8QV2nUZIheG3bJJXThjNSgW8X2ZSBAv'));
define('MPESA_SHORTCODE', getenv('174379'));
define('MPESA_CALLBACK_URL', getenv('https://test_mpay.onrender.com/m_pay/mpesa/busfares/callback.php'));
define('MPESA_ENV', getenv('MPESA_ENV') ?: 'sandbox'); // default sandbox

// Database connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
