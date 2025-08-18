<?php
$orderId = $_GET['id'];
$order = $pdo->query("SELECT * FROM orders WHERE id = ?", (int)$orderId)->fetch();
?>

<div class="tracking-container">
    <h2>Order #<?= $order['id'] ?></h2>
    <p>Status: <?= $order['status'] ?></p>
    <p>Tracking Number: <?= $order['tracking_number'] ?></p>
    
    <div id="tracking-map"></div>
    
    <script>
    // Initialize real-time tracking map
    const tracker = new ByteSwapTracker(<?= $orderId ?>);
    </script>
</div>