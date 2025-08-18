<?php
require_once __DIR__ . '/../../../app/config/database.php';
require_once __DIR__ . '/../../../app/middleware/adminAuth.php';

header('Content-Type: application/json');

$stmt = $pdo->prepare("
    SELECT * FROM admin_notifications 
    WHERE admin_id = ? AND is_read = FALSE
    ORDER BY created_at DESC
");
$stmt->execute([$_SESSION['user']['id']]);
$notifications = $stmt->fetchAll();

echo json_encode($notifications);