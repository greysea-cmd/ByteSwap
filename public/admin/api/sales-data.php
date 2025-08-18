<?php
require_once __DIR__ . '/../../../app/middleware/adminAuth.php';
adminOnly();

header('Content-Type: application/json');

$data = $pdo->query("
    SELECT 
        DATE(created_at) AS date,
        SUM(amount) AS amount
    FROM payments
    WHERE created_at > NOW() - INTERVAL 30 DAY
    GROUP BY DATE(created_at)
    ORDER BY date ASC
")->fetchAll();

$result = [
    'dates' => array_column($data, 'date'),
    'amounts' => array_column($data, 'amount')
];

echo json_encode($result);