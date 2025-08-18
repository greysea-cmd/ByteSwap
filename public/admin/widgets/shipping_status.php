<?php
require_once __DIR__ . '/../../../app/controllers/ShippingController.php';
$shippingController = new ShippingController($pdo);

$stmt = $this->pdo->query("
    SELECT o.id, l.brand, l.model, o.tracking_number
    FROM orders o
    JOIN laptops l ON o.laptop_id = l.id
    WHERE o.escrow_status = 'held' 
    AND o.tracking_number IS NOT NULL
    LIMIT 5
");
$shipments = $stmt->fetchAll();
?>

<table class="shipping-status">
    <?php foreach ($shipments as $shipment): ?>
    <?php $status = $shippingController->getTrackingStatus($shipment['tracking_number']); ?>
    <tr>
        <td><?= htmlspecialchars($shipment['brand']) ?> <?= htmlspecialchars($shipment['model']) ?></td>
        <td>
            <span class="status-badge <?= strtolower(str_replace(' ', '-', $status['status'])) ?>">
                <?= $status['status'] ?>
            </span>
        </td>
        <td>
            <?= $status['location'] ?>
        </td>
        <td>
            ETA: <?= date('M j', strtotime($status['estimated_delivery'])) ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>