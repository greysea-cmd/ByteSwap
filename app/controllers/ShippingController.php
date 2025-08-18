<?php
class ShippingController {
    private $apiKey = 'FEDEX_API_KEY';
    
    public function generateLabel($laptopId, $destination) {
        // Get laptop details from database
        $laptop = $this->getLaptop($laptopId);
        
        // Call FedEx API
        $response = $this->callFedExAPI([
            'recipient' => $destination,
            'weight' => '5kg',
            'dimensions' => '40x30x10cm',
            'insurance_value' => $laptop['price'],
            'signature_required' => true
        ]);
        
        // Save tracking number to database
        $this->saveTrackingNumber($laptopId, $response['tracking_number']);
        
        return $response['label_url'];
    }

    public function getShippingStatus($trackingNumber) {
    $response = $this->callFedExApi("/track", [
        'tracking_number' => $trackingNumber
    ]);
    
    return [
        'status' => $response['latest_status'],
        'estimated_delivery' => $response['estimated_delivery'] ?? null,
        'last_update' => $response['last_updated']
    ];
}
}