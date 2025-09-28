<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'm_pay');

define('MPESA_CONSUMER_KEY', 'uEWApsgB5NFs9FiedApURKPVDzB3fOzBlFyDwMxG7AdA26YM');
define('MPESA_CONSUMER_SECRET', 'KiItsROrqWTmygwnHAZA6QpJuzCHvWz2S8QV2nUZIheG3bJJXThjNSgW8X2ZSBAv');
define('MPESA_PASSKEY', 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919'); 
//define('MPESA_PASSKEY', 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919');  
define('MPESA_SHORTCODE', '174379'); // Use your Paybill number
//define('MPESA_CALLBACK_URL', 'https://fe2c1eda5d4a.ngrok-free.app/mpay/callback.php');
define('MPESA_CALLBACK_URL', 'https://fe2c1eda5d4a.ngrok-free.app/m_pay/mpesa/events/callback.php');

define('MPESA_ENV', 'sandbox'); // Change to 'live' for production

// Database connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>