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
            // Parse URL to extract public ID
            $parts = explode('/upload/', $url);
            if (count($parts) < 2) {
                return null;
            }

            // Remove version and get path
            $path = preg_replace('/^v\d+\//', '', $parts[1]);

            // Remove file extension
            $publicId = pathinfo($path, PATHINFO_DIRNAME) . '/' . pathinfo($path, PATHINFO_FILENAME);

            return $publicId;

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

            $publicId = self::getPublicIdFromUrl($url);
            if (!$publicId) {
                return $url;
            }

            // Determine resource type from original URL
            $resourceType = 'image';
            if (str_contains($url, '/raw/'))
                $resourceType = 'raw';
            else if (str_contains($url, '/video/'))
                $resourceType = 'video';

            // Generate signed URL with attachment flag via asset classes
            if ($resourceType === 'video') {
                return (string) Cloudinary::getVideo($publicId)->addFlag('attachment')->signUrl();
            } else if ($resourceType === 'raw') {
                return (string) Cloudinary::getFile($publicId)->addFlag('attachment')->signUrl();
            } else {
                // PDF is usually 'image' in Cloudinary but we force it to work
                return (string) Cloudinary::getImage($publicId)->addFlag('attachment')->signUrl();
            }

        } catch (\Exception $e) {
            Log::error('Failed to generate download URL', [
                'url' => $url,
                'error' => $e->getMessage()
            ]);
            return $url;
        }
    }
}
