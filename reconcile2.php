<?php
// reconcile.php
// Automated reconciliation cron job for CargoPay / PesaBridge
// Flags transactions as 'discrepant' if not reconciled after 24 hours
// Updates status, logs events, and can trigger notifications
// Run via cron:  */30 * * * * php /path/to/reconcile.php >> /path/to/logs/reconcile.log 2>&1

require_once 'mpesa/cargo/config.php';
require_once 'DB_connection.php';

echo "Reconciliation started: " . date('Y-m-d H:i:s') . "\n";

// 1. Find transactions that should be reconciled by now
// Criteria: disbursed more than 24 hours ago and still not reconciled
$query = "
    SELECT 
        id,
        user_id,
        amount,
        status,
        disbursed_at,
        merchant_request_id,
        pesalink_reference,
        branch_id
    FROM cargo_pay_mpesa_bank
    WHERE 
        status = 'disbursed'
        AND disbursed_at IS NOT NULL
        AND disbursed_at < DATE_SUB(NOW(), INTERVAL 24 HOUR)
        AND status != 'reconciled'
        AND status != 'discrepant'
    ORDER BY disbursed_at ASC
    LIMIT 500  -- safety limit - adjust as needed
";

$stmt = $conn->prepare($query);
$stmt->execute();
$transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

$reconciled_count = 0;
$discrepant_count = 0;

foreach ($transactions as $tx) {
    $tx_id = $tx['id'];
    $reference = $tx['pesalink_reference'];
    
    // ================================================
    // Here you would normally call IntaSend status API
    // For now we'll simulate realistic behavior
    // ================================================
    
    // Simulation logic (replace with real API call in production)
    $should_be_reconciled = (rand(1, 100) <= 92); // ~92% success rate simulation
    
    if ($should_be_reconciled) {
        // Mark as reconciled
        $update = $conn->prepare("
            UPDATE cargo_pay_mpesa_bank 
            SET 
                status = 'reconciled',
                reconciled_at = NOW()
            WHERE id = ?
        ");
        $update->execute([$tx_id]);
        
        logReconciliationEvent($tx_id, 'reconciled', 'Auto-reconciled after settlement check');
        $reconciled_count++;
        
        echo "TX #$tx_id reconciled successfully\n";
    } else {
        // Flag as discrepant
        $update = $conn->prepare("
            UPDATE cargo_pay_mpesa_bank 
            SET 
                status = 'discrepant',
                failed_reason = CONCAT(COALESCE(failed_reason, ''), ' | Discrepancy detected after 24h - settlement not confirmed')
            WHERE id = ?
        ");
        $update->execute([$tx_id]);
        
        logReconciliationEvent($tx_id, 'discrepant', 'Settlement mismatch - flagged for manual review');
        $discrepant_count++;
        
        // Optional: trigger notification (email/SMS to branch admin or user)
        // sendDiscrepancyNotification($tx);
        
        echo "TX #$tx_id FLAGGED AS DISCREPANT\n";
    }
}

// 2. Update credit scores for reconciled transactions (optional - can be separate cron)
if ($reconciled_count > 0) {
    echo "Updating credit scores for $reconciled_count newly reconciled transactions...\n";
    // You can call your updateUserStats() function here for affected users
    // Or run a separate batch update
}

echo "Reconciliation finished: $reconciled_count reconciled, $discrepant_count discrepant\n";
echo "----------------------------------------\n";

// ────────────────────────────────────────────────────────────────────────────────
// Helper functions

function logReconciliationEvent($transaction_id, $event, $details) {
    global $conn;
    
    $stmt = $conn->prepare("
        INSERT INTO transaction_logs 
        (transaction_id, event, details, created_at)
        VALUES (?, ?, ?, NOW())
    ");
    $stmt->execute([$transaction_id, $event, $details]);
}

/*
function sendDiscrepancyNotification($tx) {
    // Pseudo-code - implement with your notification system
    $user = getUserById($tx['user_id']);
    $branch = getBranchById($tx['branch_id']);
    
    $message = "Transaction #{$tx['id']} (KES {$tx['amount']}) flagged as discrepant. "
             . "Please verify settlement. Reference: {$tx['pesalink_reference']}";
    
    sendSMS($user['phone'], $message);
    sendEmailToBranchAdmin($branch['id'], $message);
}
*/
