<?php
// M-Pesa Sandbox Config - NO OUTPUT (no echo/print)
// Environment
define('MPESA_ENV', 'sandbox');
// M-Pesa Credentials (set these in Render Environment Variables)
define('MPESA_SHORTCODE', getenv('MPESA_SHORTCODE') ?: '174379');  // Fallback for testing
define('MPESA_PASSKEY', getenv('MPESA_PASSKEY') ?: 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919');  // Your actual sandbox passkey as fallback (replace with yours)
// Daraja API Credentials (Consumer Key/Secret from Safaricom Daraja Portal)
define('CONSUMER_KEY', getenv('CONSUMER_KEY') ?: 'uEWApsgB5NFs9FiedApURKPVDzB3fOzBlFyDwMxG7AdA26YM');  // Fallback placeholder
define('CONSUMER_SECRET', getenv('CONSUMER_SECRET') ?: 'KiItsROrqWTmygwnHAZA6QpJuzCHvWz2S8QV2nUZIheG3bJJXThjNSgW8X2ZSBAv');  // Fallback placeholder
// Specific callbacks
define('MPESA_CALLBACK_URL_TILL',       'https://test-mpay.onrender.com/mpesa/cargo/callbacktill.php');
define('MPESA_CALLBACK_URL_PAYBILL',    'https://test-mpay.onrender.com/mpesa/cargo/callbackpaybill.php');
define('CALLBACK_URL_CARGO_MPESATOBANK','https://test-mpay.onrender.com/mpesa/cargo/callbackmpesatobank.php');

define('INITIATE_URL', 'https://test-mpay.onrender.com/initiate.php');
define('INTASEND_API_KEY', getenv('INTASEND_API_KEY') ?: 'ISSecretKey_test_xxxxxxxx');

date_default_timezone_set('Africa/Nairobi');
