<?php
require_once __DIR__ . '/../../../app/middleware/adminAuth.php';
adminOnly();

global $pdo;
$stmt = $pdo->query("
    SELECT l.*, u.username AS seller 
    FROM laptops l
    JOIN users u ON l.seller_id = u.id
    WHERE l.status = 'pending_verification'
");
$laptops = $stmt->fetchAll();
?>

<!-- HTML Table -->
<table class="verification-queue">
    <thead>
        <tr>
            <th>ID</th>
            <th>Brand/Model</th>
            <th>Seller</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($laptops as $laptop): ?>
        <tr>
            <td><?= $laptop['id'] ?></td>
            <td><?= htmlspecialchars($laptop['brand']) ?> <?= htmlspecialchars($laptop['model']) ?></td>
            <td><?= $laptop['seller'] ?></td>
            <td>
                <a href="detail.php?id=<?= $laptop['id'] ?>" class="btn-inspect">
                    🔍 Inspect
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>