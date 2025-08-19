<?php
class ShippingController {
    private $apiKey;
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->apiKey = 'YOUR_FEDEX_API_KEY';
    }
    
    public function getTrackingStatus($trackingNumber) {
        // Simulated API call (replace with actual cURL request)
        return [
            'status' => 'In Transit',
            'location' => 'Memphis, TN',
            'estimated_delivery' => date('Y-m-d', strtotime('+2 days'))
        ];
    }

    private function makeApiCall($url, $data, $method = 'POST') {
        // For local development, bypass SSL verification
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->accessToken,
                'X-locale: en_US'
            ],
            CURLOPT_POST => $method === 'POST',
            CURLOPT_POSTFIELDS => $method === 'POST' ? json_encode($data) : null,
            CURLOPT_SSL_VERIFYPEER => false, // Only for localhost!
            CURLOPT_SSL_VERIFYHOST => 0      // Only for localhost!
        ]);
        
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new Exception('API Error: ' . curl_error($ch));
        }
        curl_close($ch);
        
        return json_decode($response, true);
    }
}