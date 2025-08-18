<?php
require_once __DIR__ . '/../../app/middleware/adminAuth.php';
adminOnly();

$type = $_GET['type'] ?? '';
$filename = 'byteswap-export-' . date('Y-m-d') . '.csv';

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '"');

$output = fopen('php://output', 'w');

switch ($type) {
    case 'verification_queue':
        $stmt = $pdo->query("
            SELECT l.id, l.brand, l.model, u.username AS seller, l.created_at
            FROM laptops l
            JOIN users u ON l.seller_id = u.id
            WHERE l.status = 'pending_verification'
        ");
        fputcsv($output, ['ID', 'Brand', 'Model', 'Seller', 'Submitted At']);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            fputcsv($output, $row);
        }
        break;
        
    case 'disputes':
        // Similar structure for disputes
        break;
}

fclose($output);
exit;