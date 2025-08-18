<?php
require_once __DIR__ . '/../../../app/middleware/adminAuth.php';
adminOnly();

$stmt = $pdo->query("
    SELECT d.*, b.username AS buyer, s.username AS seller
    FROM disputes d
    JOIN users b ON d.buyer_id = b.id
    JOIN users s ON d.seller_id = s.id
    WHERE d.status = 'open'
");
$disputes = $stmt->fetchAll();
?>

<!-- Dispute Table -->
<table class="disputes">
    <?php foreach ($disputes as $dispute): ?>
    <tr>
        <td>Order #<?= $dispute['order_id'] ?></td>
        <td><?= $dispute['buyer'] ?> vs <?= $dispute['seller'] ?></td>
        <td><?= substr($dispute['reason'], 0, 50) ?>...</td>
        <td>
            <a href="resolve.php?id=<?= $dispute['id'] ?>" class="btn-resolve">
                ⚖️ Resolve
            </a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>