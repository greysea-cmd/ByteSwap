<?php
require_once '../../app/config/database.php';
require_once '../../app/controllers/FraudController.php';
$suspicious = (new FraudController($pdo))->detectSuspiciousListings();
?>

<div class="fraud-alerts">
    <h4>⚠️ Suspicious Listings</h4>
    <ul>
        <?php foreach ($suspicious as $item): ?>
        <li>
            <a href="/admin/verification/detail.php?id=<?= $item['id'] ?>">
                <?= $item['brand'] ?> <?= $item['model'] ?> (<?= $item['username'] ?>)
            </a>
            <?php if ($item['price_anomaly']): ?>
            <span class="flag price-flag">Low Price</span>
            <?php endif; ?>
            <?php if ($item['new_seller']): ?>
            <span class="flag new-seller">New Seller</span>
            <?php endif; ?>
        </li>
        <?php endforeach; ?>
    </ul>
</div>