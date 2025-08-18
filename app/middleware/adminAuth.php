<?php
function adminOnly() {
    session_start();
    if (!isset($_SESSION['user']) {
        header("Location: /login?redirect=/admin");
        exit();
    }
    
    // Check database for admin role (example using PDO)
    global $pdo;
    $stmt = $pdo->prepare("SELECT is_admin FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user']['id']]);
    $user = $stmt->fetch();
    
    if (!$user || !$user['is_admin']) {
        header("HTTP/1.1 403 Forbidden");
        exit("<h1>Access Denied</h1><p>Admins only.</p>");
    }
}