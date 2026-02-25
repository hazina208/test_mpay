// 3. Initiate IntaSend payout
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => INTASEND_SANDBOX_API_URL . '/api/v1/send-money/initiate/',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        'Authorization: Bearer ' . INTASEND_BEARER_TOKEN,
        'Content-Type: application/json'
    ],
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode([
        'provider' => INTASEND_PROVIDER_BANK,  // PESALINK
        'currency' => 'KES',
        'transactions' => [
            [
                'narrative' => 'Payment to ' . $recipient_name,
                'name' => $recipient_name,
                'account' => $recipient_account,
                'bank_code' => $bank_code,
                'amount' => (float)$amount
            ]
        ]
    ]),
    // Optional but useful: get more debug info
    CURLOPT_TIMEOUT => 60,
    CURLOPT_VERBOSE => false,  // set to true temporarily if you want even more curl debug
]);

$response = curl_exec($curl);

// ────────────────────────────────────────────────
// ADD LOGGING HERE – right after curl_exec
// ────────────────────────────────────────────────
error_log("IntaSend raw response: " . $response);           // Logs the full raw body
$http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
error_log("IntaSend HTTP status code: " . $http_code);      // e.g. 200, 400, 500
error_log("IntaSend curl error (if any): " . curl_error($curl));

// Also log the sent payload for comparison (very helpful)
$sent_payload = json_encode([
    'provider' => INTASEND_PROVIDER_BANK,
    'currency' => 'KES',
    'transactions' => [
        [
            'narrative' => 'Payment to ' . $recipient_name,
            'name' => $recipient_name,
            'account' => $recipient_account,
            'bank_code' => $bank_code,
            'amount' => (float)$amount
        ]
    ]
]);
error_log("IntaSend request payload: " . $sent_payload);
// ────────────────────────────────────────────────

$curl_error = curl_error($curl);
curl_close($curl);

if ($curl_error) {
    // Rollback status on cURL failure
    $conn->prepare("UPDATE cargo_pay_bank_bank SET status = 'FAILED' WHERE id = ?")
         ->execute([$local_tx_id]);
    http_response_code(500);
    echo json_encode(['message' => 'cURL error contacting IntaSend: ' . $curl_error]);
    exit;
}

// Now try to decode
$resp_data = json_decode($response, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    // Log if JSON is invalid – very useful for debugging
    error_log("IntaSend JSON decode failed: " . json_last_error_msg());
    error_log("Raw response that failed to decode: " . $response);
    
    // Mark as failed
    $conn->prepare("UPDATE cargo_pay_bank_bank SET status = 'FAILED' WHERE id = ?")
         ->execute([$local_tx_id]);
    http_response_code(500);
    echo json_encode([
        'message' => 'IntaSend returned invalid JSON',
        'raw_response' => $response  // send raw to Flutter for visibility
    ]);
    exit;
}

if (isset($resp_data['tracking_id'])) {
    $tracking_id = $resp_data['tracking_id'];
    // Update with tracking ID
    $update = $conn->prepare("
        UPDATE cargo_pay_bank_bank
        SET transaction_id = :tracking_id, status = 'INITIATED'
        WHERE id = :id
    ");
    $update->execute([':tracking_id' => $tracking_id, ':id' => $local_tx_id]);
    echo json_encode([
        'message' => 'Payment initiated',
        'tracking_id' => $tracking_id
    ]);
} else {
    // Mark as failed
    $conn->prepare("UPDATE cargo_pay_bank_bank SET status = 'FAILED' WHERE id = ?")
         ->execute([$local_tx_id]);
    http_response_code(500);
    echo json_encode([
        'message' => 'IntaSend initiation failed',
        'details' => $resp_data ?? $response,  // fallback to raw if decode failed earlier
        'http_code' => $http_code              // also include status code
    ]);
}
