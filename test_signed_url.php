<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Log;

// Test with a dummy public ID or a real one if known
$publicId = 'uploads/test_file';

echo "Testing Signed URL Generation...\n";

try {
    // Attempt 1: Using Cloudinary Facade to get underlying object
    // Assuming we can access the underlying Cloudinary\Cloudinary object
    // typical usage in v2 SDK: Configuration::instance();

    // In cloudinary-laravel, Cloudinary facade might proxy to CloudinaryEngine
    // But we need the Url helper.

    // Let's try to get a URL with sign_url option
    // This is often how it's done in the PHP SDK

    // $url = cloudinary()->uploadApi()->... no that's for upload.

    // We need the 'image' or 'video' helper equivalent.

    // Try to inspect what Cloudinary::class gives us
    // var_dump(get_class(Cloudinary::getFacadeRoot()));

    /* 
       The official way usually involves:
       (new \Cloudinary\Cloudinary($config))->image($publicId)->toUrl();
    */

    echo "Filesystem Config: " . json_encode(config('cloudinary')) . "\n";

    // Let's manually construct a signed URL using the config
    $cloudName = config('cloudinary.cloud_name');
    $apiKey = config('cloudinary.api_key');
    $apiSecret = config('cloudinary.api_secret');

    if (!$apiSecret) {
        echo "Error: API Secret is missing from config.\n";
        exit;
    }

    $timestamp = time();
    $params = [
        'timestamp' => $timestamp,
        'public_id' => $publicId,
        'fl' => 'attachment' // Force download
    ];

    // Cloudinary signature generation
    ksort($params);
    $str_to_sign = "";
    foreach ($params as $k => $v) {
        if ($k == 'public_id' || $k == 'fl') {
            // actually signature for transformation URL is different
        }
    }

    // Let's use the SDK if possible.
    // Try accessing the Tag Helper via the facade if it exposes it?
    // Cloudinary::getImage($publicId) ?

    echo "Attempting to usage Cloudinary\Configuration...\n";

    // Re-initialize straightforwardly
    $c = new \Cloudinary\Cloudinary([
        'cloud' => [
            'cloud_name' => $cloudName,
            'api_key' => $apiKey,
            'api_secret' => $apiSecret,
        ],
        'url' => [
            'secure' => true
        ]
    ]);

    $url = $c->image($publicId)
        ->addTransformation(['flags' => 'attachment'])
        ->signUrl(true)
        ->toUrl(); // generate URL

    echo "Generated Signed URL: " . $url . "\n";

} catch (\Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
