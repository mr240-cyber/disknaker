<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$cloudUrl = config('cloudinary.cloud_url', env('CLOUDINARY_URL'));
echo "Cloud URL: " . $cloudUrl . "\n";
$c = new \Cloudinary\Cloudinary($cloudUrl);

$comp = $c->image('sample');
echo "Class: " . get_class($comp) . "\n";
echo "Methods: \n";
print_r(get_class_methods($comp));
