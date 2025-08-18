<?php
class ListingsController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createListing($sellerId, $brand, $model, $serial, $specs, $condition, $price) {
        $verificationCode = bin2hex(random_bytes(8));
        $stmt = $this->pdo->prepare("INSERT INTO laptops 
            (seller_id, brand, model, serial_number, specs, `condition`, price, verification_code) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        
        return $stmt->execute([
            $sellerId, $brand, $model, $serial, 
            json_encode($specs), $condition, $price, $verificationCode
        ]);
    }
}