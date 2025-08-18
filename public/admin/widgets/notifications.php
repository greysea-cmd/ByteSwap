<?php
$notifications = $pdo->query("
    SELECT n.id, n.message, n.created_at
    FROM notifications n
    WHERE n.user_id = :user_id
    ORDER BY n.created_at DESC
    LIMIT 5
")->fetchAll();
?>

<ul class="notification-list">
    <?php foreach ($notifications as $notification): ?>
    <li>
        <span class="message"><?= htmlspecialchars($notification['message']) ?></span>
        <span class="date"><?= date('M j', strtotime($notification['created_at'])) ?></span>
    </li>
    <?php endforeach; ?>
</ul>