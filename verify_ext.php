<?php
require 'vendor/autoload.php';

$cloudName = 'dm3wdi4ac';
$apiKey = '893389145376138';
$apiSecret = '86chWRBuXR8XU0X0eJ52Od_9M6o';

use Cloudinary\Configuration\Configuration;
use Cloudinary\Asset\Image;

$config = Configuration::instance();
$config->cloud->cloudName = $cloudName;
$config->cloud->apiKey = $apiKey;
$config->cloud->apiSecret = $apiSecret;
$config->url->secure = true;

echo "Verifying URL generation with extension in path...\n";

$publicIdWithExt = 'uploads/surat_balasan/phpWL0d0X_hwqohg.pdf';

// Test 1: Extension in Path
$asset1 = new Image($publicIdWithExt);
$asset1->addFlag('attachment');
$asset1->version('1');
echo "URL (Ext in path): " . (string) $asset1->signUrl() . "\n";

// Test 2: No ext in path, but format() used
$asset2 = new Image('uploads/surat_balasan/phpWL0d0X_hwqohg');
$asset2->addFlag('attachment');
$asset2->format('pdf');
$asset2->version('1');
echo "URL (format()): " . (string) $asset2->signUrl() . "\n";
