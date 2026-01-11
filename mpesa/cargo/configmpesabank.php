<?php
// config.php - 2025 version
define('DB_HOST', 'localhost');
define('DB_NAME', 'pesabridge_db');
define('DB_USER', 'root');          // Change in production
define('DB_PASS', '');

define('DARAJA_ENV', 'sandbox');    // 'live' when going production
define('DARAJA_CONSUMER_KEY', 'YOUR_CONSUMER_KEY');
define('DARAJA_CONSUMER_SECRET', 'YOUR_CONSUMER_SECRET');
define('DARAJA_SHORTCODE', '174379'); // Sandbox
define('DARAJA_PASSKEY', 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919');

define('INTASEND_API_KEY', 'YOUR_INTASEND_SANDBOX_KEY'); // Wrapper for PesaLink
define('CALLBACK_URL', 'https://yourdomain.com/backend/callback.php');
define('INITIATE_URL', 'https://yourdomain.com/backend/api/initiate.php');

date_default_timezone_set('Africa/Nairobi');
?>
