<?php
require 'vendor/autoload.php';

$cloudName = 'dm3wdi4ac';
$apiKey = '893389145376138';
$apiSecret = '86chWRBuXR8XU0X0eJ52Od_9M6o';

use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Admin\AdminApi;

$config = Configuration::instance();
$config->cloud->cloudName = $cloudName;
$config->cloud->apiKey = $apiKey;
$config->cloud->apiSecret = $apiSecret;

$adminApi = new AdminApi();

$publicId = 'uploads/surat_balasan/phpNcTRT2_t54wsd';

echo "Inspecting resource: $publicId\n";

try {
    // In SDK v2, it's often asset()
    echo "Checking as IMAGE...\n";
    $result = $adminApi->asset($publicId, ['resource_type' => 'image']);
    echo "FOUND as IMAGE\n";
    print_r($result);
} catch (\Exception $e) {
    echo "Not image or error: " . $e->getMessage() . "\n";
    try {
        echo "Checking as RAW...\n";
        $result = $adminApi->asset($publicId, ['resource_type' => 'raw']);
        echo "FOUND as RAW\n";
        print_r($result);
    } catch (\Exception $e2) {
        echo "Not raw or error: " . $e2->getMessage() . "\n";
    }
}
