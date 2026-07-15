<?php

// Quick Cloudinary Connection Test
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Cloudinary Configuration Test ===\n\n";

// Check if env variables are loaded
echo "1. Environment Variables:\n";
echo "   CLOUDINARY_CLOUD_NAME: " . (env('CLOUDINARY_CLOUD_NAME') ?: 'NOT SET') . "\n";
echo "   CLOUDINARY_API_KEY: " . (env('CLOUDINARY_API_KEY') ?: 'NOT SET') . "\n";
echo "   CLOUDINARY_API_SECRET: " . (env('CLOUDINARY_API_SECRET') ? '***SET***' : 'NOT SET') . "\n";
echo "   CLOUDINARY_URL: " . (env('CLOUDINARY_URL') ? '***SET***' : 'NOT SET') . "\n\n";

// Check if CloudinaryService exists
echo "2. CloudinaryService Class:\n";
if (class_exists('App\Services\CloudinaryService')) {
    echo "   ✅ CloudinaryService class found\n";

    // Check if methods exist
    $reflection = new ReflectionClass('App\Services\CloudinaryService');
    echo "   ✅ upload() method: " . ($reflection->hasMethod('upload') ? 'exists' : 'missing') . "\n";
    echo "   ✅ delete() method: " . ($reflection->hasMethod('delete') ? 'exists' : 'missing') . "\n";
} else {
    echo "   ❌ CloudinaryService class NOT found\n";
    echo "   Run: composer dump-autoload\n";
}

echo "\n3. Cloudinary Package:\n";
if (class_exists('CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary')) {
    echo "   ✅ Cloudinary package installed\n";
} else {
    echo "   ❌ Cloudinary package NOT found\n";
}

echo "\n=== Test Complete ===\n";
