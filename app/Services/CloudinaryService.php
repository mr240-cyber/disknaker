<?php

namespace App\Services;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\UploadedFile;

class CloudinaryService
{
    public static $lastError = null;

    /**
     * Upload a file to Cloudinary
     */
    public static function upload(UploadedFile $file, string $folder = 'uploads'): ?string
    {
        try {
            $cloudUrl = trim(config('cloudinary.cloud_url', ''));

            if (!$cloudUrl) {
                // Fallback to env if config returns empty string/null unexpectedly
                $cloudUrl = env('CLOUDINARY_URL');
            }

            if (!$cloudUrl) {
                $msg = 'Cloudinary URL is not configured';
                Log::error('Cloudinary (Upload): ' . $msg);
                self::$lastError = $msg;
                return null;
            }

            Log::debug('Cloudinary (Upload): Attempting upload', [
                'folder' => $folder,
                'file' => $file->getClientOriginalName()
            ]);

            // Ensure folder is clean
            $folder = trim($folder, '/');

            $uploadedFileUrl = Cloudinary::upload($file->getRealPath(), [
                'folder' => $folder,
                'resource_type' => 'auto',
                'use_filename' => true,
                'unique_filename' => true,
            ])->getSecurePath();

            Log::info('Cloudinary (Upload): Success', ['url' => $uploadedFileUrl]);
            return $uploadedFileUrl;

        } catch (\Exception $e) {
            self::$lastError = $e->getMessage();
            Log::error('Cloudinary Upload Failed', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Delete a file from Cloudinary
     */
    public static function delete(string $publicId): bool
    {
        try {
            Cloudinary::destroy($publicId);
            return true;
        } catch (\Exception $e) {
            Log::error('Cloudinary Delete Failed', ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Extract public ID from Cloudinary URL (preserving extension if present)
     */
    public static function getPublicIdFromUrl(string $url): ?string
    {
        $parsed = self::parseCloudinaryUrl($url);
        return $parsed ? $parsed['public_id'] : null;
    }

    /**
     * Parse Cloudinary URL to get resource type, type and public_id
     */
    private static function parseCloudinaryUrl(string $url): ?array
    {
        try {
            if (empty($url))
                return null;

            // Basic parsing to handle standard Cloudinary URLs
            $path = parse_url($url, PHP_URL_PATH);

            // Regex to capture: /cloud_name/resource_type/type/(v\d+/)?public_id
            // Example: /demo/image/upload/v12345/folder/file.jpg
            if (preg_match('#^/([^/]+)/([^/]+)/([^/]+)/(?:v\d+/)?(.+)$#', $path, $matches)) {
                return [
                    'cloud_name' => $matches[1],
                    'resource_type' => $matches[2], // image, raw, video
                    'type' => $matches[3], // upload, authenticated, private
                    'public_id' => urldecode($matches[4]) // folder/file.ext
                ];
            }

            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get the download URL (Signed with fl_attachment)
     */
    public static function getDownloadUrl(string $url): string
    {
        try {
            $parsed = self::parseCloudinaryUrl($url);

            if (!$parsed) {
                return $url;
            }

            // Manually configure accessible Cloudinary instance for signing
            // We need to parse the CLOUDINARY_URL environment variable or config
            // to get api_key and api_secret if not readily available via Facade in this context.
            // Using the full URL string in constructor is supported by Cloudinary PHP SDK.

            $cloudUrl = config('cloudinary.cloud_url');
            if (!$cloudUrl)
                $cloudUrl = env('CLOUDINARY_URL');

            if (!$cloudUrl)
                return $url;

            $c = new \Cloudinary\Cloudinary($cloudUrl);

            $publicId = $parsed['public_id'];
            $resourceType = $parsed['resource_type'];

            // Do not strip extension automatically. 
            // If the URL contains extension, we should preserve it to ensure we sign the exact same resource path.
            // Cloudinary SDK respects the publicId we pass.

            if ($resourceType === 'image') {
                $comp = new \Cloudinary\Asset\Image($publicId);
            } elseif ($resourceType === 'video') {
                $comp = new \Cloudinary\Asset\Video($publicId);
            } else {
                $comp = new \Cloudinary\Asset\File($publicId);
            }

            $comp->configuration($c->configuration);

            // valid options for URL generation
            // fl_attachment forces download
            if ($resourceType !== 'raw') {
                $comp->addGenericQualifier('fl', 'attachment');
            }

            // Sign the URL
            $comp->signUrl(true);

            return $comp->toUrl();

        } catch (\Exception $e) {
            Log::error('Cloudinary GetDownloadUrl Failed: ' . $e->getMessage());
            return $url;
        }
    }
}
