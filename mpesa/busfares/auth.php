<?php
require_once 'config.php';

function getAccessToken() {
    $credentials = base64_encode(CONSUMER_KEY . ':' . CONSUMER_SECRET);
    $url = MPESA_ENV == 'sandbox'
        ? 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials'
        : 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'Authorization: Basic ' . $credentials,
        'Content-Type: application/json'
    ]);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        error_log("cURL Error: " . $err);
        return false;
    }

    $data = json_decode($response, true);
    return isset($data['access_token']) ? $data['access_token'] : false;
}
?>