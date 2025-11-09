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

// Callback URL
define('MPESA_CALLBACK_URL11', 'https://test-mpay.onrender.com/mpesa/water/callback.php');