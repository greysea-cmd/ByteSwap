<?php
require_once __DIR__ . '/../../app/config/database.php';
require_once __DIR__ . '/../../app/controllers/ListingsController.php';

$listingsController = new ListingsController($pdo);
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $specs = [
        'cpu' => $_POST['cpu'],
        'ram' => $_POST['ram'],
        'storage' => $_POST['storage'],
        'gpu' => $_POST['gpu']
    ];

    $success = $listingsController->createListing(
        $_SESSION['user_id'],
        $_POST['brand'],
        $_POST['model'],
        $_POST['serial_number'],
        $specs,
        $_POST['condition'],
        $_POST['price']
    );

    if ($success) {
        header("Location: /dashboard/listings?success=1");
        exit();
    } else {
        $errors[] = "Failed to create listing. Serial number may already exist.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/assets/css/main.css">
    <title>Create Listing | ByteSwap</title>
</head>

<body>
    <?php include __DIR__ . '/../../app/views/partials/header.php'; ?>

    <div class="auth-form">
        <h2>Create Listing</h2>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="brand" placeholder="Brand" required>
            <input type="text" name="model" placeholder="Model" required>
            <input type="text" name="serial_number" placeholder="Serial Number" required>
            <input type="text" name="cpu" placeholder="CPU" required>
            <input type="text" name="ram" placeholder="RAM" required>
            <input type="text" name="storage" placeholder="Storage" required>
            <input type="text" name="gpu" placeholder="GPU" required>
            <select name="condition" required>
                <option value="">Select Condition</option>
                <option value="new">New</option>
                <option value="used">Used</option>
            </select>
            <input type="number" name="price" placeholder="Price" required>
            <button type="submit">Create Listing</button>
        </form>
    </div>

    <?php include __DIR__ . '/../../app/views/partials/footer.php'; ?>
</body>

</html>