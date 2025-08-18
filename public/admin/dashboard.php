<?php
require_once __DIR__ . '/../../../app/middleware/adminAuth.php';
adminOnly();

// Fetch stats
global $pdo;
$stats = [
    'pending_verifications' => $pdo->query("SELECT COUNT(*) FROM laptops WHERE status = 'pending_verification'")->fetchColumn(),
    'open_disputes' => $pdo->query("SELECT COUNT(*) FROM disputes WHERE status = 'open'")->fetchColumn(),
    'unshipped_verified' => $pdo->query("SELECT COUNT(*) FROM laptops WHERE status = 'verified' AND shipping_label IS NULL")->fetchColumn(),
    'recent_sales' => $pdo->query("SELECT SUM(amount) FROM payments WHERE created_at > NOW() - INTERVAL 7 DAY")->fetchColumn()
];
?>

<div class="admin-dashboard">
    <!-- Top Stats Row -->
    <div class="stats-row">
        <div class="stat-card verification-pending">
            <h3>Pending Verifications</h3>
            <p><?= $stats['pending_verifications'] ?></p>
            <a href="/admin/verification/pending.php" class="btn-action">Review</a>
        </div>
        
        <div class="stat-card open-disputes">
            <h3>Open Disputes</h3>
            <p><?= $stats['open_disputes'] ?></p>
            <a href="/admin/disputes" class="btn-action">Resolve</a>
        </div>
        
        <div class="stat-card ready-to-ship">
            <h3>Ready to Ship</h3>
            <p><?= $stats['unshipped_verified'] ?></p>
            <a href="/admin/shipping/labels.php" class="btn-action">Generate Labels</a>
        </div>
        
        <div class="stat-card weekly-sales">
            <h3>Weekly Sales</h3>
            <p>$<?= number_format($stats['recent_sales'], 2) ?></p>
        </div>
    </div>
    
    <!-- Middle Content -->
    <div class="content-row">
        <!-- Verification Queue Widget -->
        <div class="widget verification-queue">
            <h3>Verification Queue</h3>
            <?php include __DIR__ . '/widgets/verification_queue.php'; ?>
        </div>
        
        <!-- Recent Disputes Widget -->
        <div class="widget recent-disputes">
            <h3>Recent Disputes</h3>
            <?php include __DIR__ . '/widgets/recent_disputes.php'; ?>
        </div>
    </div>
    
    <!-- Bottom Row -->
    <div class="chart-row">
        <!-- Sales Chart -->
        <div class="widget sales-chart">
            <h3>Sales Last 30 Days</h3>
            <canvas id="salesChart"></canvas>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script src="/assets/js/admin-dashboard.js"></script>