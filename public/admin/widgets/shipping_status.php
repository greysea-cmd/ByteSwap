<?php
$pendingShipments = $pdo->query("
    SELECT o.id, l.brand, l.model, o.tracking_number
    FROM orders o
    JOIN laptops l ON o.laptop_id = l.id
    WHERE o.escrow_status = 'held' 
    AND o.tracking_number IS NOT NULL
    LIMIT 5
")->fetchAll();

$shipping = new ShippingController();
?>

<table class="shipping-status">
    <?php foreach ($pendingShipments as $shipment): ?>
    <?php $status = $shipping->getShippingStatus($shipment['tracking_number']); ?>
    <tr>
        <td><?= $shipment['brand'] ?> <?= $shipment['model'] ?></td>
        <td>
            <span class="status-badge <?= strtolower(str_replace(' ', '-', $status['status'])) ?>">
                <?= $status['status'] ?>
            </span>
        </td>
        <td>
            <?php if ($status['estimated_delivery']): ?>
            ETA: <?= date('M j', strtotime($status['estimated_delivery'])) ?>
            <?php endif; ?>
        </td>
        <td>
            <a href="<?= $shipping->getTrackingUrl($shipment['tracking_number']) ?>" target="_blank">
                Track
            </a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>