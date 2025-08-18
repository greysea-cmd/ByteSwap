<?php
require_once __DIR__ . '/../../../app/middleware/adminAuth.php';
adminOnly();

$laptopId = $_GET['id'];
$stmt = $pdo->prepare("
    SELECT l.*, u.username AS seller 
    FROM laptops l
    JOIN users u ON l.seller_id = u.id
    WHERE l.id = ?
");
$stmt->execute([$laptopId]);
$laptop = $stmt->fetch();

// Handle verification submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['is_authentic'] ? 'verified' : 'rejected';
    $notes = $_POST['notes'];
    
    $pdo->prepare("
        UPDATE laptops 
        SET status = ?, verification_notes = ?
        WHERE id = ?
    ")->execute([$status, $notes, $laptopId]);
    
    header("Location: pending.php?verified=1");
    exit();
}
?>

<!-- Verification Form -->
<form method="POST" class="verification-form">
    <div class="laptop-details">
        <h2><?= $laptop['brand'] ?> <?= $laptop['model'] ?></h2>
        <p><strong>Serial:</strong> <?= $laptop['serial_number'] ?></p>
        <img src="/uploads/<?= $laptop['photos'] ?>" alt="Laptop Photos">
    </div>
    
    <div class="verification-checklist">
        <label>
            <input type="checkbox" name="check_serial" required>
            Serial matches manufacturer records
        </label>
        <!-- More checklist items -->
    </div>
    
    <textarea name="notes" placeholder="Inspection notes..."></textarea>
    
    <div class="verdict-buttons">
        <button type="submit" name="is_authentic" value="1" class="btn-approve">
            ✅ Approve
        </button>
        <button type="submit" name="is_authentic" value="0" class="btn-reject">
            ❌ Reject
        </button>
    </div>
</form>