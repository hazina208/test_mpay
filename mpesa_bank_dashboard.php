<?php require_once 'DB_connection.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>PesaBridge Dashboard - 2025</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1>PesaBridge Admin Dashboard</h1>
        
        <!-- Transactions Table -->
        <h3>Recent Transactions</h3>
        <table class="table table-striped">
            <thead><tr><th>ID</th><th>Amount</th><th>Status</th><th>Phone</th><th>Bank</th><th>Date</th></tr></thead>
            <tbody>
            <?php
            $stmt = $pdo->query("SELECT t.*, u.phone FROM cargo_pay_mpesa_bank t JOIN resgister u ON t.user_id = u.id ORDER BY t.id DESC LIMIT 50");
            while ($row = $stmt->fetch()) {
                echo "<tr><td>{$row['id']}</td><td>KES {$row['amount']}</td><td>{$row['status']}</td><td>{$row['phone']}</td><td>Bank {$row['recipient_bank_code']}</td><td>{$row['created_at']}</td></tr>";
            }
            ?>
            </tbody>
        </table>
        
        <!-- Credit Scores -->
        <h3>User Credit Scores</h3>
        <!-- Similar table -->
        
        <!-- Charts -->
        <canvas id="volumeChart" width="400" height="200"></canvas>
    </div>
    
    <script>
    // Example Chart.js volume chart
    const ctx = document.getElementById('volumeChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Transaction Volume (KES)',
                data: [120000, 190000, 300000, 500000, 420000, 600000],
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        }
    });
    </script>
</body>
</html>
