<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\CloudinaryService;

// Mock a Cloudinary URL
$mockUrl = 'https://res.cloudinary.com/demo/image/upload/v123456789/sample.jpg';
echo "Original URL: " . $mockUrl . "\n";

$signedUrl = CloudinaryService::getDownloadUrl($mockUrl);

echo "Signed URL: " . $signedUrl . "\n";

if (strpos($signedUrl, 's--') !== false) {
    echo "SUCCESS: URL contains signature.\n";
} else {
    echo "FAILURE: URL does not contain signature.\n";
}

// Check if 'fl_attachment' is present (encoded or not)
if (strpos($signedUrl, 'fl_attachment') !== false || strpos($signedUrl, 'fl_') !== false) {
    echo "SUCCESS: URL contains attachment flag.\n";
} else {
    echo "WARNING: URL might not contain attachment flag.\n";
}
