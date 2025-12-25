<?php
require 'vendor/autoload.php';

$url = "https://res.cloudinary.com/dm3wdi4ac/image/upload/fl_attachment/v1766113232/uploads/surat_balasan/phpNcTRT2_t54wsd.pdf";

echo "Testing URL: $url\n";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_NOBODY, true); // Just headers
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code: $httpCode\n";
echo "Response:\n$response\n";
