<?php
require 'vendor/autoload.php';

// Load .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo "=== Vercel Blob Test ===\n\n";

// Check if class exists
echo "1. Checking VercelBlobPhp\\Client class... ";
if (class_exists('VercelBlobPhp\Client')) {
    echo "FOUND ✓\n";
} else {
    echo "NOT FOUND ✗\n";
    echo "   Trying to find what classes are available...\n";

    // Check autoload classmap
    $classmap = require 'vendor/composer/autoload_classmap.php';
    foreach ($classmap as $class => $file) {
        if (stripos($class, 'blob') !== false || stripos($class, 'vercel') !== false) {
            echo "   Found: {$class}\n";
        }
    }
    exit(1);
}

// Check token
echo "2. Checking BLOB_READ_WRITE_TOKEN... ";
$token = $_ENV['BLOB_READ_WRITE_TOKEN'] ?? getenv('BLOB_READ_WRITE_TOKEN');
if ($token) {
    echo "SET ✓ (starts with: " . substr($token, 0, 20) . "...)\n";
} else {
    echo "NOT SET ✗\n";
    exit(1);
}

// Try to instantiate client
echo "3. Instantiating Client... ";
try {
    $client = new VercelBlobPhp\Client($token);
    echo "OK ✓\n";
} catch (Exception $e) {
    echo "FAILED ✗\n";
    echo "   Error: " . $e->getMessage() . "\n";
    exit(1);
}

// Try to upload a test string
echo "4. Testing upload... ";
try {
    $testContent = "Hello, this is a test file from PHP at " . date('Y-m-d H:i:s');
    $pathname = 'test/test_' . uniqid() . '.txt';

    $response = $client->put($pathname, $testContent);

    echo "OK ✓\n";
    echo "   URL: " . ($response->url ?? $response['url'] ?? 'unknown') . "\n";

} catch (Exception $e) {
    echo "FAILED ✗\n";
    echo "   Error: " . $e->getMessage() . "\n";
    echo "   Trace: " . $e->getTraceAsString() . "\n";
}

echo "\n=== Test Complete ===\n";
