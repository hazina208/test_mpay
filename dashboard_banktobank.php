<?php
include '../config.php';
session_start();
// Assume logged in user_id = 1; add auth logic

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$user_id = 1; // From session

// Fetch credit score
$score_query = mysqli_query($conn, "SELECT credit_score FROM users WHERE id = $user_id");
$score = mysqli_fetch_assoc($score_query)['credit_score'];

// Lower fees example: if score > 100, fee = 1%; else 2%
$fee = ($score > 100) ? '1%' : '2%';

// Cash flow: Inflows/outflows with filters (date/branch)
$date_filter = isset($_GET['date']) ? mysqli_real_escape_string($conn, $_GET['date']) : date('Y-m-d');
$branch_filter = isset($_GET['branch']) ? mysqli_real_escape_string($conn, $_GET['branch']) : '';

// Query logs
$logs_sql = "SELECT l.*, t.branch FROM logs l JOIN transactions t ON l.transaction_id = t.id WHERE DATE(l.created_at) = '$date_filter'";
if ($branch_filter) $logs_sql .= " AND t.branch = '$branch_filter'";
$logs = mysqli_query($conn, $logs_sql);

// Transactions for reconciliation/verification
$tx_sql = "SELECT * FROM transactions WHERE user_id = $user_id ORDER BY created_at DESC LIMIT 10";
$transactions = mysqli_query($conn, $tx_sql);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Payment Dashboard</h1>
        
        <!-- Credit Scoring -->
        <div class="card mb-4">
            <div class="card-header">Data-Driven Credit Scoring</div>
            <div class="card-body">
                <p>Your Credit Score: <?php echo $score; ?></p>
                <p>Current Fee Rate: <?php echo $fee; ?> (Higher score unlocks lower fees)</p>
            </div>
        </div>
        
        <!-- Cash Flow -->
        <div class="card mb-4">
            <div class="card-header">Delayed Settlement & Cash Flow</div>
            <div class="card-body">
                <form method="GET" class="mb-3">
                    <div class="row">
                        <div class="col">
                            <input type="date" name="date" value="<?php echo $date_filter; ?>" class="form-control">
                        </div>
                        <div class="col">
                            <input type="text" name="branch" placeholder="Branch" value="<?php echo $branch_filter; ?>" class="form-control">
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>
                <table class="table table-striped">
                    <thead>
                        <tr><th>Type</th><th>Amount</th><th>Description</th><th>Date</th></tr>
                    </thead>
                    <tbody>
                        <?php while ($log = mysqli_fetch_assoc($logs)): ?>
                            <tr>
                                <td><?php echo $log['event_type']; ?></td>
                                <td><?php echo $log['amount']; ?></td>
                                <td><?php echo $log['description']; ?></td>
                                <td><?php echo $log['created_at']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Reconciliation & Verification -->
        <div class="card">
            <div class="card-header">Automated Reconciliation & Real-Time Verification</div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr><th>Tx ID</th><th>Amount</th><th>Recipient</th><th>Status</th><th>Action</th></tr>
                    </thead>
                    <tbody>
                        <?php while ($tx = mysqli_fetch_assoc($transactions)): ?>
                            <tr>
                                <td><?php echo $tx['transaction_id']; ?></td>
                                <td><?php echo $tx['amount']; ?></td>
                                <td><?php echo $tx['recipient_name']; ?></td>
                                <td><?php echo $tx['status']; ?> <?php if ($tx['status'] == 'DISCREPANT') echo '(Notified)'; ?></td>
                                <td><button class="btn btn-sm btn-info" onclick="verify('<?php echo $tx['transaction_id']; ?>')">Verify</button></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function verify(trackingId) {
            // AJAX to api/verify.php
            fetch('/api/verify.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({tracking_id: trackingId})
            }).then(res => res.json()).then(data => alert('Status: ' + data.status));
        }
    </script>
</body>
</html>
