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
                $msg = 'Cloudinary URL is not configured in config/cloudinary.php';
                Log::error('Cloudinary (Upload): ' . $msg);
                self::$lastError = $msg;
                return null;
            }

            Log::debug('Cloudinary (Upload): Attempting upload', [
                'folder' => $folder,
                'file' => $file->getClientOriginalName()
            ]);

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
        try {
            if (empty($url))
                return null;
            $url = explode('?', $url)[0];

            if (!preg_match('~/(upload|private|authenticated|raw|video|image)/~', $url))
                return null;

            $pos = strrpos($url, '/upload/');
            if ($pos === false)
                return null;

            $afterUpload = substr($url, $pos + strlen('/upload/'));

            // Matches: [v123/][path/to/public_id.ext]
            if (preg_match('~^(?:.*/)?v\d+/(.+)~', $afterUpload, $pathMatches)) {
                return $pathMatches[1];
            }
            return $afterUpload;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get the download URL (Opens in browser)
     */
    public static function getDownloadUrl(string $url): string
    {
        // Return original URL to avoid 401 errors from Strict Transformations
        // User can download manually from the browser viewer
        return $url;
    }
}
