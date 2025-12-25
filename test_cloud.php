<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

try {
    $root = Cloudinary::getFacadeRoot();
    echo "Root Class: " . get_class($root) . "\n";

    // Print available methods on the root object
    $methods = get_class_methods($root);
    sort($methods);
    echo "Methods: " . implode(', ', $methods) . "\n\n";

    // Attempt to mimic generation logic
    // Usually Cloudinary wrapper has 'image' or 'getUrl'
    // Let's see what happens if we call a few standard ones

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
