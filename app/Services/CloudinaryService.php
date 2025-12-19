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
     * Extract public ID from Cloudinary URL
     */
    public static function getPublicIdFromUrl(string $url): ?string
    {
        try {
            if (empty($url))
                return null;
            $url = explode('?', $url)[0];

            // Matches: .../upload/[v1234/][public_id].[ext]
            if (!preg_match('~/(upload|private|authenticated|raw|video|image)/~', $url))
                return null;

            $pos = strrpos($url, '/upload/');
            if ($pos === false)
                return null;

            $afterUpload = substr($url, $pos + strlen('/upload/'));

            // Extract public path ignoring version v123/
            if (preg_match('~^(?:.*/)?v\d+/(.+)~', $afterUpload, $pathMatches)) {
                return $pathMatches[1];
            }
            return $afterUpload;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Generate a signed download URL with fl_attachment
     */
    public static function getDownloadUrl(string $url): string
    {
        try {
            if (empty($url) || !str_contains($url, 'cloudinary.com')) {
                return $url;
            }

            // 1. Extract Info
            if (!preg_match('~cloudinary\.com/([^/]+)/(image|video|raw)/(upload|private|authenticated)/~', $url, $matches)) {
                return $url;
            }

            $extractedCloudName = $matches[1];
            $resourceType = $matches[2];
            $deliveryType = $matches[3];

            $publicIdWithExt = self::getPublicIdFromUrl($url);
            if (!$publicIdWithExt)
                return $url;

            $extension = pathinfo($publicIdWithExt, PATHINFO_EXTENSION);
            $cleanPublicId = $extension ? substr($publicIdWithExt, 0, -(strlen($extension) + 1)) : $publicIdWithExt;

            // 2. Build Asset via SDK Builder
            if ($resourceType === 'raw') {
                $asset = Cloudinary::getFile($publicIdWithExt);
            } else {
                $asset = ($resourceType === 'video') ? Cloudinary::getVideo($cleanPublicId) : Cloudinary::getImage($cleanPublicId);
                if ($extension)
                    $asset->format($extension);
            }

            // 3. FORCE SETTINGS & VERSION
            // Force Cloud Name from URL to handle mismatches
            $asset->setCloudConfig('cloud_name', $extractedCloudName);
            $asset->addFlag('attachment');

            // Hardcode version 1 to match existing signed patterns if needed
            $asset->version('1');

            // 4. Final Sign
            $finalUrl = (string) $asset->signUrl();

            Log::debug('Cloudinary Automatic Signed URL', [
                'cloud' => $extractedCloudName,
                'resource' => $resourceType,
                'final_url' => $finalUrl
            ]);

            return $finalUrl;

        } catch (\Exception $e) {
            Log::error('Cloudinary Signed URL Error', ['error' => $e->getMessage()]);
            return $url;
        }
    }
}
