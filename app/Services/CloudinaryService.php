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
            $cloudName = config('cloudinary.cloud_url') ?: env('CLOUDINARY_URL');

            if (!$cloudName) {
                Log::error('Cloudinary Upload Failed: CLOUDINARY_URL not configured');
                return null;
            }

            $uploadedFileUrl = Cloudinary::upload($file->getRealPath(), [
                'folder' => $folder,
                'resource_type' => 'auto',
                'use_filename' => true,
                'unique_filename' => true,
            ])->getSecurePath();

            Log::info('Cloudinary Upload Success', ['url' => $uploadedFileUrl]);
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
            if (!preg_match('~/(upload|private|authenticated|raw|video|image)/~', $url))
                return null;
            $pos = strrpos($url, '/upload/');
            if ($pos === false)
                return null;
            $afterUpload = substr($url, $pos + strlen('/upload/'));
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

            // 1. Precise extraction
            if (!preg_match('~/(image|video|raw)/(upload|private|authenticated)/~', $url, $matches)) {
                return $url;
            }

            $resourceType = $matches[1];
            $searchStr = $matches[0];
            $pos = strpos($url, $searchStr);
            $afterDelivery = substr($url, $pos + strlen($searchStr));
            $pathParts = explode('?', $afterDelivery)[0];

            // Extract version and public path
            if (preg_match('~^v\d+/~', $pathParts, $vMatches)) {
                $pathNoVersion = substr($pathParts, strlen($vMatches[0]));
            } else {
                $pathNoVersion = $pathParts;
            }

            $extension = pathinfo($pathNoVersion, PATHINFO_EXTENSION);

            // 2. Prepare Asset
            if ($resourceType === 'raw') {
                $asset = Cloudinary::getFile($pathNoVersion);
            } else {
                $publicId = $extension ? substr($pathNoVersion, 0, -(strlen($extension) + 1)) : $pathNoVersion;
                $asset = ($resourceType === 'video') ? Cloudinary::getVideo($publicId) : Cloudinary::getImage($publicId);
                if ($extension) {
                    $asset->format($extension);
                }
            }

            // 3. Apply transformation and sign
            // Using direct transformation string for maximum compatibility
            $finalUrl = (string) $asset->addTransformation('fl_attachment')->signUrl();

            // Debug Logic to detect cloud name mismatch
            preg_match('~cloudinary\.com/([^/]+)/~', $finalUrl, $genMatches);
            $genCloud = $genMatches[1] ?? 'unknown';

            Log::debug('Cloudinary Signed URL Processed', [
                'gen_cloud' => $genCloud,
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
