<?php
header('Content-Type: application/json');
echo json_encode([
    'access_token' => 'mock_access_token_'.bin2hex(random_bytes(8)),
    'expires_in' => 3600,
    'token_type' => 'Bearer'
]);