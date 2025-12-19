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
     *
     * @param UploadedFile $file The file to upload
     * @param string $folder The folder path in Cloudinary (e.g., 'uploads/pelkes')
     * @return string|null The secure URL of the uploaded file, or null on failure
     */
    public static function upload(UploadedFile $file, string $folder = 'uploads'): ?string
    {
        try {
            // Verify credentials are loaded
            $cloudName = config('cloudinary.cloud_url') ?: env('CLOUDINARY_URL');

            if (!$cloudName) {
                Log::error('Cloudinary Upload Failed: CLOUDINARY_URL not configured', [
                    'folder' => $folder,
                    'file' => $file->getClientOriginalName(),
                    'env_cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                    'env_api_key' => env('CLOUDINARY_API_KEY') ? 'SET' : 'NOT SET',
                ]);
                return null;
            }

            // Upload file to Cloudinary
            $uploadedFileUrl = Cloudinary::upload($file->getRealPath(), [
                'folder' => $folder,
                'resource_type' => 'auto', // Automatically detect file type
                'use_filename' => true, // Use original filename
                'unique_filename' => true, // Add unique suffix to prevent overwrites
            ])->getSecurePath();

            Log::info('Cloudinary Upload Success', [
                'folder' => $folder,
                'url' => $uploadedFileUrl,
                'original_name' => $file->getClientOriginalName()
            ]);

            return $uploadedFileUrl;

        } catch (\Exception $e) {
            self::$lastError = $e->getMessage();
            Log::error('Cloudinary Upload Failed', [
                'folder' => $folder,
                'error' => $e->getMessage(),
                'error_class' => get_class($e),
                'file' => $file->getClientOriginalName(),
                'trace' => $e->getTraceAsString(),
            ]);

            return null;
        }
    }

    /**
     * Delete a file from Cloudinary
     *
     * @param string $publicId The public ID of the file to delete
     * @return bool True on success, false on failure
     */
    public static function delete(string $publicId): bool
    {
        try {
            Cloudinary::destroy($publicId);

            Log::info('Cloudinary Delete Success', ['public_id' => $publicId]);

            return true;

        } catch (\Exception $e) {
            Log::error('Cloudinary Delete Failed', [
                'public_id' => $publicId,
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }

    /**
     * Extract public ID from Cloudinary URL
     * Example: https://res.cloudinary.com/demo/image/upload/v1234/folder/file.pdf
     * Returns: folder/file
     *
     * @param string $url The Cloudinary URL
     * @return string|null The public ID or null if invalid
     */
    public static function getPublicIdFromUrl(string $url): ?string
    {
        try {
            if (empty($url))
                return null;

            // 1. Remove query parameters
            $url = explode('?', $url)[0];

            // 2. Identify the part after /upload/ (or other delivery types)
            if (!preg_match('~/(upload|private|authenticated|raw|video|image)/~', $url, $matches, PREG_OFFSET_CAPTURE)) {
                return null;
            }

            // Find the last occurrence of these delivery keywords to be safe
            $pos = strrpos($url, '/upload/');
            if ($pos === false) {
                // Try other types if upload isn't there (though it usually is)
                if (preg_match('~/(?:private|authenticated)/~', $url, $m, PREG_OFFSET_CAPTURE)) {
                    $pos = $m[0][1];
                } else {
                    return null;
                }
            }

            $afterUpload = substr($url, $pos + strlen('/upload/'));

            // 3. Extract public ID (everything after the version v\d+/)
            // Format: [transformations]/v[version]/[public_id]
            if (preg_match('~^(?:.*/)?v\d+/(.+)~', $afterUpload, $pathMatches)) {
                $publicIdWithExt = $pathMatches[1];
            } else {
                // If no version exists, it might be just the public ID or transformations/publicID
                // This is less common but we'll take the whole thing and hope for the best
                $publicIdWithExt = $afterUpload;
            }

            // 4. Return the full path including extension
            // Cloudinary SDK handles public IDs with extensions correctly by including them in the final URL.
            return $publicIdWithExt;

        } catch (\Exception $e) {
            Log::error('Failed to extract public ID from URL', [
                'url' => $url,
                'error' => $e->getMessage()
            ]);

            return null;
        }
    }

    /**
     * Generate a signed download URL with fl_attachment
     *
     * @param string $url The original Cloudinary URL
     * @return string The signed download URL
     */
    public static function getDownloadUrl(string $url): string
    {
        try {
            if (empty($url) || !str_contains($url, 'cloudinary.com')) {
                return $url;
            }

            // 1. Precise extraction of resource type and path
            // Format: .../{resource_type}/{delivery_type}/[version/][public_id].[ext]
            if (!preg_match('~/(image|video|raw)/(upload|private|authenticated)/~', $url, $matches)) {
                return $url;
            }

            $resourceType = $matches[1];
            $deliveryType = $matches[2];
            $searchStr = $matches[0];

            $pos = strpos($url, $searchStr);
            $afterDelivery = substr($url, $pos + strlen($searchStr));

            // Separate path and query
            $pathParts = explode('?', $afterDelivery)[0];

            // Extract version if exists
            $version = null;
            if (preg_match('~^v\d+/~', $pathParts, $vMatches)) {
                $version = rtrim($vMatches[0], '/');
                $pathNoVersion = substr($pathParts, strlen($vMatches[0]));
            } else {
                $pathNoVersion = $pathParts;
            }

            $extension = pathinfo($pathNoVersion, PATHINFO_EXTENSION);

            // 2. Prepare the asset object for signing
            if ($resourceType === 'raw') {
                // For raw, public ID MUST include extension
                $asset = Cloudinary::getFile($pathNoVersion);
            } else {
                // For image/video, strip extension and use format()
                $publicId = $extension ? substr($pathNoVersion, 0, -(strlen($extension) + 1)) : $pathNoVersion;

                if ($resourceType === 'video') {
                    $asset = Cloudinary::getVideo($publicId);
                } else {
                    $asset = Cloudinary::getImage($publicId);
                }

                if ($extension) {
                    $asset->format($extension);
                }
            }

            // 3. Add flags and sign
            // Using array for addTransformation to avoid strict type lints
            $asset->addTransformation(['flags' => 'attachment']);

            $finalUrl = (string) $asset->signUrl();

            Log::debug('Cloudinary Signed URL Generated', [
                'resource_type' => $resourceType,
                'path' => $pathNoVersion,
                'extension' => $extension,
                'signed_url' => $finalUrl,
                'config_url' => config('cloudinary.cloud_url') ? 'SET' : 'NOT SET'
            ]);

            return $finalUrl;

        } catch (\Exception $e) {
            Log::error('Failed to generate download URL', [
                'url' => $url,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return $url;
        }
    }
}
