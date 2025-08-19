<?php
header('Content-Type: application/json');

// Simulate authentication
if (!isset($_SERVER['HTTP_AUTHORIZATION']) {
    http_response_code(401);
    die(json_encode(['error' => 'Unauthorized']));
}

// Mock tracking data
$mockTrackingData = [
    '123456789' => [
        'status' => 'In transit',
        'location' => 'Memphis, TN',
        'estimated_delivery' => date('Y-m-d', strtotime('+2 days')),
        'last_scan' => date('Y-m-d H:i:s')
    ],
    '987654321' => [
        'status' => 'Delivered',
        'location' => 'New York, NY',
        'estimated_delivery' => date('Y-m-d'),
        'last_scan' => date('Y-m-d H:i:s', strtotime('-1 hour'))
    ]
];

$trackingNumber = $_POST['trackingInfo'][0]['trackingNumberInfo']['trackingNumber'] ?? null;

if (!$trackingNumber || !isset($mockTrackingData[$trackingNumber])) {
    http_response_code(404);
    die(json_encode(['error' => 'Tracking number not found']));
}

echo json_encode([
    'output' => [
        'completeTrackResults' => [
            [
                'trackResults' => [
                    [
                        'latestStatusDetail' => [
                            'statusByLocale' => $mockTrackingData[$trackingNumber]['status']
                        ],
                        'scanEvents' => [
                            [
                                'scanLocation' => [
                                    'city' => explode(',', $mockTrackingData[$trackingNumber]['location'])[0],
                                    'stateOrProvinceCode' => 'TN'
                                ],
                                'date' => $mockTrackingData[$trackingNumber]['last_scan']
                            ]
                        ],
                        'estimatedDeliveryTimeWindow' => [
                            'ends' => $mockTrackingData[$trackingNumber]['estimated_delivery']
                        ]
                    ]
                ]
            ]
        ]
    ]
]);