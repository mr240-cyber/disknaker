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

$publicIdWithExt = 'uploads/surat_balasan/phpNcTRT2_t54wsd.pdf';
$version = '1766113232';

echo "Testing with Public ID with EXT and REAL version...\n";

$asset = new Image($publicIdWithExt);
$asset->addFlag('attachment');
$asset->version($version);
$url = (string) $asset->signUrl();

echo "Final Test URL: $url\n";

if (str_contains($url, 'uploads/surat_balasan/phpNcTRT2_t54wsd.pdf')) {
    echo "SUCCESS: Extension is in the path.\n";
} else {
    echo "FAILURE: Extension is missing from path.\n";
}

if (str_contains($url, $version)) {
    echo "SUCCESS: Correct version is in the URL.\n";
} else {
    echo "FAILURE: Version mismatch.\n";
}
