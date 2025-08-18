<?php
$queue = $pdo->query("
    SELECT l.id, l.brand, l.model, u.username AS seller, l.created_at 
    FROM laptops l
    JOIN users u ON l.seller_id = u.id
    WHERE l.status = 'pending_verification'
    ORDER BY l.created_at ASC
    LIMIT 5
")->fetchAll();
?>

<table class="widget-table">
    <thead>
        <tr>
            <th>Brand/Model</th>
            <th>Seller</th>
            <th>Submitted</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($queue as $item): ?>
        <tr>
            <td><?= htmlspecialchars($item['brand']) ?> <?= htmlspecialchars($item['model']) ?></td>
            <td><?= $item['seller'] ?></td>
            <td><?= date('M j', strtotime($item['created_at'])) ?></td>
            <td><a href="/admin/verification/detail.php?id=<?= $item['id'] ?>" class="btn-small">Inspect</a></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>