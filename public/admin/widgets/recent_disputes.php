<?php
$disputes = $pdo->query("
    SELECT d.id, d.reason, b.username AS buyer, d.created_at
    FROM disputes d
    JOIN users b ON d.buyer_id = b.id
    WHERE d.status = 'open'
    ORDER BY d.created_at DESC
    LIMIT 5
")->fetchAll();
?>

<ul class="dispute-list">
    <?php foreach ($disputes as $dispute): ?>
    <li>
        <span class="reason"><?= htmlspecialchars(substr($dispute['reason'], 0, 50)) ?>...</span>
        <span class="meta">
            <span class="buyer"><?= $dispute['buyer'] ?></span>
            <span class="date"><?= date('M j', strtotime($dispute['created_at'])) ?></span>
            <a href="/admin/disputes/resolve.php?id=<?= $dispute['id'] ?>" class="btn-small">Resolve</a>
        </span>
    </li>
    <?php endforeach; ?>
</ul>