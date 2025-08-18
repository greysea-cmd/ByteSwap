<?php
require_once __DIR__ . '/../../../app/middleware/adminAuth.php';
adminOnly();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $laptopIds = $_POST['laptop_ids'];
    foreach ($laptopIds as $id) {
        // Generate label 
        $labelUrl = $shipping->generateLabel($id);
        $pdo->prepare("UPDATE laptops SET shipping_label = ? WHERE id = ?")
           ->execute([$labelUrl, $id]);
    }
    header("Location: labels.php?generated=1");
    exit();
}

$stmt = $pdo->query("SELECT * FROM laptops WHERE status = 'verified' AND shipping_label IS NULL");
$readyToShip = $stmt->fetchAll();
?>

<form method="POST">
    <table>
        <?php foreach ($readyToShip as $laptop): ?>
        <tr>
            <td><input type="checkbox" name="laptop_ids[]" value="<?= $laptop['id'] ?>"></td>
            <td><?= $laptop['brand'] ?> <?= $laptop['model'] ?></td>
            <td><?= $laptop['serial_number'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <button type="submit" class="btn-generate">🚀 Generate Labels</button>
</form>