<?php
// M-Pesa Sandbox Config - NO OUTPUT (no echo/print)
// Environment
define('MPESA_ENV', 'sandbox');
define('INTASEND_API_URL', getenv('INTASEND_API_URL') ?:'https://payment.intasend.com'); 
define('INTASEND_SANDBOX_API_URL', getenv('INTASEND_SANDBOX_API_URL') ?: 'https://sandbox.intasend.com');   
define('INTASEND_LIVE_API_URL', getenv('INTASEND_LIVE_API_URL') ?: 'https://payment.intasend.com');   
define('INTASEND_BEARER_TOKEN', getenv('INTASEND_BEARER_TOKEN') ?: 'ISSecretKey_live_3d7b01ab-8448-4c54-9c62-5337fcaf6e69');//your_sandbox_or_live_secret_key_here
define('INTASEND_PROVIDER_BANK', getenv('INTASEND_PROVIDER_BANK') ?: 'PESALINK');
// M-Pesa Credentials (set these in Render Environment Variables)
define('CARGO_MPESA_SHORTCODE', getenv('CARGO_MPESA_SHORTCODE') ?: '174379');  // Fallback for testing
define('MPESA_PASSKEY', getenv('MPESA_PASSKEY') ?: 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919');  // Your actual sandbox passkey as fallback (replace with yours)
// Daraja API Credentials (Consumer Key/Secret from Safaricom Daraja Portal)
define('CONSUMER_KEY', getenv('CONSUMER_KEY') ?: 'uEWApsgB5NFs9FiedApURKPVDzB3fOzBlFyDwMxG7AdA26YM');  // Fallback placeholder
define('CONSUMER_SECRET', getenv('CONSUMER_SECRET') ?: 'KiItsROrqWTmygwnHAZA6QpJuzCHvWz2S8QV2nUZIheG3bJJXThjNSgW8X2ZSBAv');  // Fallback placeholder
// Specific callbacks
define('MPESA_CALLBACK_URL_TILL', getenv('MPESA_CALLBACK_URL_TILL') ?: 'https://test-mpay.onrender.com/mpesa/cargo/callbacktill.php');
define('MPESA_CALLBACK_URL_PAYBILL', getenv('MPESA_CALLBACK_URL_PAYBILL') ?: 'https://test-mpay.onrender.com/mpesa/cargo/callbackpaybill.php');
define('CALLBACK_URL_CARGO_MPESATOBANK', getenv('CALLBACK_URL_CARGO_MPESATOBANK') ?: 'https://test-mpay.onrender.com/mpesa/cargo/callbackmpesa_bank.php');

define('INITIATE_URL', getenv('INITIATE_URL') ?: 'https://test-mpay.onrender.com/initiate.php');
//define('INTASEND_API_KEY',  getenv('INTASEND_API_KEY') ?: 'ISSecretKey_test_8447f187-f6f3-4b75-8e45-fb020f09e6da'); // Wrapper for PesaLink// this is api key for testing
define('INTASEND_API_KEY',  getenv('INTASEND_API_KEY') ?: 'ISSecretKey_live_3d7b01ab-8448-4c54-9c62-5337fcaf6e69');
define('WEBHOOK_SECRET', getenv('WEBHOOK_SECRET') ?: 'https://test-mpay.onrender.com/webhook.php'); // For verifying webhooks

date_default_timezone_set('Africa/Nairobi');
