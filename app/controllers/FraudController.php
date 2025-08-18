<?php
class FraudController {
    public function detectSuspiciousListings($pdo) {
        return $pdo->query("
            SELECT l.*, u.username, 
                   (l.price < (avg_price * 0.7)) AS price_anomaly,
                   (u.created_at > NOW() - INTERVAL 7 DAY) AS new_seller
            FROM laptops l
            JOIN users u ON l.seller_id = u.id
            JOIN (
                SELECT brand, model, AVG(price) AS avg_price 
                FROM laptops 
                WHERE status = 'verified'
                GROUP BY brand, model
            ) AS avg_prices ON l.brand = avg_prices.brand AND l.model = avg_prices.model
            WHERE l.status = 'pending_verification'
            HAVING price_anomaly = 1 OR new_seller = 1
        ")->fetchAll();
    }
}