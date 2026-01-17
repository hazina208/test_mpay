<?php
// dashboard/index.php - CargoPay Beautiful Analytics Dashboard
// January 2026 version - Focus on Reconciliation, Cash Flow, Verification & Credit Scoring

require_once 'mpesa/cargo/config.php';
require_once 'DB_connection.php';

// Sample data fetching (add real filters later via GET/POST)
$transactions = $conn->query("
    SELECT t.*, u.phone, b.name as branch_name 
    FROM cargo_pay_mpesa_bank t 
    LEFT JOIN users u ON t.user_id = u.id 
    LEFT JOIN branches b ON t.branch_id = b.id 
    ORDER BY t.created_at DESC 
    LIMIT 50
")->fetchAll(PDO::FETCH_ASSOC);

$users = conno->query("
    SELECT u.*, b.name as branch_name 
    FROM users u 
    LEFT JOIN branches b ON u.branch_id = b.id 
    ORDER BY u.credit_score DESC 
    LIMIT 30
")->fetchAll(PDO::FETCH_ASSOC);

$branches = $conn->query("SELECT * FROM branches")->fetchAll(PDO::FETCH_ASSOC);

// Aggregates
$total_in     = $conn->query("SELECT SUM(amount) FROM cargo_pay_mpesa_bank WHERE status IN ('collected','disbursed')")->fetchColumn() ?? 0;
$total_out    = $conn->query("SELECT SUM(amount) FROM cargo_pay_mpesa_bank WHERE status = 'disbursed'")->fetchColumn() ?? 0;
$discrepant   = $conn->query("SELECT COUNT(*) FROM cargo_pay_mpesa_bank WHERE disbursed_at < DATE_SUB(NOW(), INTERVAL 24 HOUR) AND status != 'reconciled'")->fetchColumn() ?? 0;
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>CargoPay Dashboard • Analytics & Insights</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        :root { --primary: #3b82f6; --success: #10b981; --warning: #f59e0b; --danger: #ef4444; }
        body { background: linear-gradient(to bottom right, #f1f5f9, #e2e8f0); min-height: 100vh; }
        .sidebar { background: #1e293b; color: white; }
        .card { border-radius: 1rem; overflow: hidden; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); transition: transform 0.2s; }
        .card:hover { transform: translateY(-4px); }
        .status-badge { padding: 0.35rem 0.75rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 500; }
    </style>
</head>
<body class="font-sans antialiased">

<!-- Sidebar Navigation -->
<nav class="sidebar fixed top-0 left-0 h-full w-64 p-6 flex flex-col">
    <div class="text-2xl font-bold mb-10">CargoPay</div>
    <ul class="space-y-2">
        <li><a href="#dashboard" class="block py-3 px-4 rounded-lg hover:bg-gray-700 transition">Dashboard</a></li>
        <li><a href="#reconciliation" class="block py-3 px-4 rounded-lg hover:bg-gray-700 transition">Reconciliation</a></li>
        <li><a href="#cashflow" class="block py-3 px-4 rounded-lg hover:bg-gray-700 transition">Cash Flow</a></li>
        <li><a href="#verification" class="block py-3 px-4 rounded-lg hover:bg-gray-700 transition">Verification</a></li>
        <li><a href="#credit" class="block py-3 px-4 rounded-lg hover:bg-gray-700 transition">Credit Scoring</a></li>
    </ul>
</nav>

<!-- Main Content -->
<main class="ml-64 p-8">
    <header class="mb-10">
        <h1 class="text-4xl font-extrabold text-gray-900">Analytics Dashboard</h1>
        <p class="text-lg text-gray-600 mt-2">Real-time insights • Reconciliation • Cash Flow • Verification • Credit Scoring</p>
    </header>

    <!-- 1. Automated Reconciliation -->
    <section id="reconciliation" class="mb-12">
        <div class="card bg-white p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">Automated Reconciliation</h2>
                <span class="status-badge bg-red-100 text-red-800">Discrepant: <?= $discrepant ?></span>
            </div>
            <p class="text-gray-600 mb-4">System checks settlement after 24 hours. Mismatches flagged as <strong>discrepant</strong> → auto-notify users/branches.</p>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-4">ID</th>
                            <th class="px-6 py-4">Amount</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Branch</th>
                            <th class="px-6 py-4">Disbursed</th>
                            <th class="px-6 py-4">Flag</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_slice($transactions, 0, 10) as $tx): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium"><?= $tx['id'] ?></td>
                            <td class="px-6 py-4"><?= number_format($tx['amount'], 2) ?></td>
                            <td class="px-6 py-4">
                                <span class="status-badge <?php 
                                    echo match($tx['status']) {
                                        'disbursed' => 'bg-green-100 text-green-800',
                                        'collected' => 'bg-blue-100 text-blue-800',
                                        'failed'    => 'bg-red-100 text-red-800',
                                        default     => 'bg-gray-100 text-gray-800'
                                    };
                                ?>">
                                    <?= ucfirst($tx['status']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4"><?= $tx['branch_name'] ?? 'N/A' ?></td>
                            <td class="px-6 py-4"><?= $tx['disbursed_at'] ?? '—' ?></td>
                            <td class="px-6 py-4 text-red-600"><?= (strtotime($tx['disbursed_at']) < strtotime('-24 hours') && $tx['status'] !== 'reconciled') ? 'Discrepant' : '' ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- 2. Delayed Settlement & Cash Flow -->
    <section id="cashflow" class="mb-12">
        <div class="card bg-white p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Delayed Settlement & Cash Flow</h2>
            <p class="text-gray-600 mb-6">Webhooks update DB instantly. View inflows/outflows with date & branch filters.</p>

            <!-- Filters -->
            <div class="flex flex-wrap gap-4 mb-6">
                <input type="date" class="border rounded-lg px-4 py-2">
                <input type="date" class="border rounded-lg px-4 py-2">
                <select class="border rounded-lg px-4 py-2">
                    <option>All Branches</option>
                    <?php foreach($branches as $b): ?>
                        <option value="<?= $b['id'] ?>"><?= $b['name'] ?></option>
                    <?php endforeach; ?>
                </select>
                <button class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Apply</button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-green-50 p-6 rounded-xl text-center">
                    <p class="text-sm text-green-700">Inflows</p>
                    <p class="text-3xl font-bold text-green-800 mt-2"><?= number_format($total_in, 0) ?> KES</p>
                </div>
                <div class="bg-red-50 p-6 rounded-xl text-center">
                    <p class="text-sm text-red-700">Outflows</p>
                    <p class="text-3xl font-bold text-red-800 mt-2"><?= number_format($total_out, 0) ?> KES</p>
                </div>
                <div class="bg-blue-50 p-6 rounded-xl text-center">
                    <p class="text-sm text-blue-700">Net Position</p>
                    <p class="text-3xl font-bold text-blue-800 mt-2"><?= number_format($total_in - $total_out, 0) ?> KES</p>
                </div>
            </div>

            <canvas id="cashFlowChart" height="140"></canvas>
        </div>
    </section>

    <!-- 3. Real-Time Verification (Multi-Branch) -->
    <section id="verification" class="mb-12">
        <div class="card bg-white p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Real-Time Verification • Multi-Branch</h2>
            <p class="text-gray-600 mb-6">B2B users share Tx IDs across branches. Status updated via webhooks/polling.</p>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-4">Tx ID</th>
                            <th class="px-6 py-4">From Branch</th>
                            <th class="px-6 py-4">To Branch</th>
                            <th class="px-6 py-4">Amount</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Last Update</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_slice($transactions, 0, 8) as $tx): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium"><?= $tx['id'] ?></td>
                            <td class="px-6 py-4">Main</td>
                            <td class="px-6 py-4"><?= $tx['branch_name'] ?? 'Mlolongo' ?></td>
                            <td class="px-6 py-4"><?= number_format($tx['amount'], 0) ?></td>
                            <td class="px-6 py-4">
                                <span class="status-badge <?php echo $tx['status'] === 'disbursed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' ?>">
                                    <?= ucfirst($tx['status']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4"><?= $tx['disbursed_at'] ?? $tx['collected_at'] ?? $tx['created_at'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- 4. Data-Driven Credit Scoring -->
    <section id="credit">
        <div class="card bg-white p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Data-Driven Credit Scoring</h2>
            <p class="text-gray-600 mb-6">Updated automatically on completed transfers. Higher score → lower fees & priority.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h3 class="text-xl font-medium mb-4">Top Users</h3>
                    <div class="space-y-4">
                        <?php foreach (array_slice($users, 0, 6) as $user): ?>
                        <div class="flex justify-between items-center bg-gray-50 p-4 rounded-lg">
                            <div>
                                <p class="font-medium"><?= $user['phone'] ?></p>
                                <p class="text-sm text-gray-500"><?= $user['branch_name'] ?? '—' ?></p>
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-bold <?= $user['credit_score'] > 650 ? 'text-green-600' : 'text-orange-600' ?>">
                                    <?= $user['credit_score'] ?>
                                </div>
                                <div class="text-xs <?= $user['credit_score'] > 750 ? 'text-green-600' : ($user['credit_score'] > 650 ? 'text-yellow-600' : 'text-red-600') ?>">
                                    <?= $user['credit_score'] > 750 ? 'Premium' : ($user['credit_score'] > 650 ? 'Discount' : 'Standard') ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div>
                    <h3 class="text-xl font-medium mb-4">Score Distribution</h3>
                    <canvas id="scoreDistribution" height="180"></canvas>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Chart.js Scripts -->
<script>
    // Cash Flow Chart
    const cfCtx = document.getElementById('cashFlowChart').getContext('2d');
    new Chart(cfCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            datasets: [
                { label: 'Inflows', data: [65000,78000,92000,105000,118000,130000,145000], borderColor: 'rgb(34,197,94)', tension: 0.3, fill: true, backgroundColor: 'rgba(34,197,94,0.15)' },
                { label: 'Outflows', data: [48000,59000,71000,82000,94000,105000,118000], borderColor: 'rgb(239,68,68)', tension: 0.3, fill: true, backgroundColor: 'rgba(239,68,68,0.15)' }
            ]
        },
        options: { responsive: true, scales: { y: { beginAtZero: true } } }
    });

    // Score Distribution Chart
    const scoreCtx = document.getElementById('scoreDistribution').getContext('2d');
    new Chart(scoreCtx, {
        type: 'doughnut',
        data: {
            labels: ['Excellent (>750)', 'Good (650-750)', 'Fair (500-650)', 'Needs Attention (<500)'],
            datasets: [{
                data: [12, 18, 25, 8],
                backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#ef4444'],
                borderWidth: 0
            }]
        },
        options: { responsive: true, cutout: '65%', plugins: { legend: { position: 'bottom' } } }
    });
</script>
</body>
</html>
