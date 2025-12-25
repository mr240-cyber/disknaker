<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use DB;

// Using community package: dam-bal/vercel-blob-php
use VercelBlobPhp\Client;

class VercelBlobService
{
    /**
     * Upload a file to Vercel Blob
     * Returns the public URL of the uploaded file.
     */
    public static function upload(UploadedFile $file, string $folder = 'uploads'): ?string
    {
        try {
            $token = env('BLOB_READ_WRITE_TOKEN');
            if (!$token) {
                Log::error('BLOB_READ_WRITE_TOKEN is missing in .env');
                return null;
            }

            $client = new Client($token);

            // Vercel Blob typically stores flat, but we can simulate folders by prefixing name
            // Note: API might change, but typically pathname is supported
            $filename = $folder . '/' . uniqid() . '_' . $file->getClientOriginalName();

            // Put file - the package uses 2 args: pathname, content
            // Access is public by default
            $response = $client->put($filename, file_get_contents($file->getRealPath()));

            // Response is a PutBlobResult object with url property
            return $response->url ?? null;

        } catch (\Exception $e) {
            Log::error('Vercel Blob Upload Failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get the download URL (Direct Link)
     * Vercel Blob URLs are public if access is public.
     */
    public static function getDownloadUrl(string $url): string
    {
        // No signing needed for public blobs
        return $url;
    }
}
