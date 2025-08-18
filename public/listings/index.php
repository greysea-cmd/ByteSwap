<?php
require_once __DIR__ . '/../../app/config/database.php';
require_once __DIR__ . '/../../app/controllers/ListingsController.php';

$listingsController = new ListingsController($pdo);
$listings = $listingsController->getAllListings();
?>

<div class="listings-grid">
    <?php foreach ($listings as $listing): ?>
        <div class="listing-card">
            <h3><?= htmlspecialchars($listing['brand']) ?> <?= htmlspecialchars($listing['model']) ?></h3>
            <p>Condition: <?= $listing['condition'] ?></p>
            <p>Price: $<?= number_format($listing['price'], 2) ?></p>
            <a href="/listings/view.php?id=<?= $listing['id'] ?>">View Details</a>
        </div>
    <?php endforeach; ?>
</div>