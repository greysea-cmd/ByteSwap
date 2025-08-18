<?php
require_once __DIR__ . '/../../../app/controllers/FraudController.php';
$fraudController = new FraudController($pdo);
$suspicious = $fraudController->detectSuspiciousListings();
?>

<div class="fraud-alerts">
    <h4>⚠️ Suspicious Listings</h4>
    <?php if (empty($suspicious)): ?>
        <p>No suspicious listings detected</p>
    <?php else: ?>
        <ul>
            <?php foreach ($suspicious as $item): ?>
            <li>
                <a href="/admin/verification/detail.php?id=<?= $item['id'] ?>">
                    <?= htmlspecialchars($item['brand']) ?> <?= htmlspecialchars($item['model']) ?>
                </a>
                <span class="flags">
                    <?php if ($item['price_anomaly']): ?>
                    <span class="flag price-flag">Low Price</span>
                    <?php endif; ?>
                    <?php if ($item['new_seller']): ?>
                    <span class="flag new-seller">New Seller</span>
                    <?php endif; ?>
                </span>
            </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>