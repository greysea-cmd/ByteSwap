<?php
require_once __DIR__ . '/../../../app/middleware/adminAuth.php';
adminOnly();

$disputeId = $_GET['id'];
$dispute = $pdo->prepare("SELECT * FROM disputes WHERE id = ?")->execute([$disputeId])->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $decision = $_POST['decision']; // 'refund_buyer' or 'release_seller'
    
    // Update dispute status
    $pdo->prepare("UPDATE disputes SET status = ? WHERE id = ?")
       ->execute([$decision, $disputeId]);
    
    // Process payment (Stripe example)
    if ($decision === 'refund_buyer') {
        $stripe->refunds->create([
            'payment_intent' => $dispute['stripe_payment_id']
        ]);
    }
    
    header("Location: index.php?resolved=1");
    exit();
}
?>

<form method="POST">
    <h3>Dispute #<?= $dispute['id'] ?></h3>
    <p><strong>Reason:</strong> <?= $dispute['reason'] ?></p>
    
    <div class="decision-buttons">
        <button type="submit" name="decision" value="refund_buyer" class="btn-refund">
            💸 Refund Buyer
        </button>
        <button type="submit" name="decision" value="release_seller" class="btn-release">
            🏷️ Release to Seller
        </button>
    </div>
</form>