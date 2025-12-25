<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\VercelBlobService;

class MigrateCloudinaryToBlob extends Command
{
    protected $signature = 'migrate:cloudinary-to-blob {--dry-run : Show what would be migrated without actually migrating}';
    protected $description = 'Migrate all Cloudinary URLs in database to Vercel Blob';

    // Tables and columns that may contain file URLs
    private $tables = [
        'pelayanan_kesekerja' => [
            'file_balasan',
            'f_permohonan',
            'f_struktur',
            'f_pernyataan',
            'f_skp_dokter',
            'f_hiperkes_dokter',
            'f_hiperkes_paramedis',
            'f_str_dokter',
            'f_sip_dokter',
            'f_sarana',
            'f_bpjs_kt',
            'f_bpjs_kes',
            'f_wlkp'
        ],
        'sk_p2k3' => [
            'file_balasan',
            'f_sk_lama',
            'f_surat_permohonan',
            'f_sertifikat_ahli_k3',
            'f_sertifikat_tambahan',
            'f_bpjs_kt',
            'f_bpjs_kes',
            'f_wlkp'
        ],
        'pelaporan_kk_pak' => ['file_balasan', 'file_bukti'],
        'pelaporan_p2k3' => ['file_balasan', 'file_laporan'],
    ];

    public function handle()
    {
        $dryRun = $this->option('dry-run');

        if ($dryRun) {
            $this->info("=== DRY RUN MODE - No changes will be made ===\n");
        }

        $totalMigrated = 0;
        $totalFailed = 0;

        foreach ($this->tables as $table => $columns) {
            $this->info("Processing table: {$table}");

            foreach ($columns as $column) {
                // Check if column exists
                if (!$this->columnExists($table, $column)) {
                    continue;
                }

                // Find all Cloudinary URLs in this column
                $records = DB::table($table)
                    ->whereNotNull($column)
                    ->where($column, 'LIKE', '%cloudinary.com%')
                    ->select('id', $column)
                    ->get();

                if ($records->isEmpty()) {
                    continue;
                }

                $this->line("  Found {$records->count()} Cloudinary URLs in {$column}");

                foreach ($records as $record) {
                    $oldUrl = $record->$column;

                    if ($dryRun) {
                        $this->line("    [DRY] Would migrate: {$oldUrl}");
                        $totalMigrated++;
                        continue;
                    }

                    try {
                        // Download from Cloudinary
                        $this->line("    Downloading: {$oldUrl}");
                        $fileContent = @file_get_contents($oldUrl);

                        if ($fileContent === false) {
                            $this->error("    Failed to download: {$oldUrl}");
                            $totalFailed++;
                            continue;
                        }

                        // Extract filename from URL
                        $pathInfo = pathinfo(parse_url($oldUrl, PHP_URL_PATH));
                        $filename = $pathInfo['basename'] ?? 'file_' . uniqid();

                        // Determine folder based on table
                        $folder = $this->getFolderForTable($table);

                        // Upload to Vercel Blob using raw content
                        $newUrl = $this->uploadToVercelBlob($fileContent, $folder, $filename);

                        if (!$newUrl) {
                            $this->error("    Failed to upload to Vercel Blob");
                            $totalFailed++;
                            continue;
                        }

                        // Update database
                        DB::table($table)->where('id', $record->id)->update([
                            $column => $newUrl
                        ]);

                        $this->info("    Migrated: {$filename} -> {$newUrl}");
                        $totalMigrated++;

                    } catch (\Exception $e) {
                        $this->error("    Error: " . $e->getMessage());
                        Log::error("Migration error for {$table}.{$column} ID {$record->id}: " . $e->getMessage());
                        $totalFailed++;
                    }
                }
            }
        }

        $this->newLine();
        $this->info("=== Migration Complete ===");
        $this->info("Total migrated: {$totalMigrated}");
        $this->info("Total failed: {$totalFailed}");

        return Command::SUCCESS;
    }

    private function columnExists($table, $column): bool
    {
        try {
            return \Schema::hasColumn($table, $column);
        } catch (\Exception $e) {
            return false;
        }
    }

    private function getFolderForTable($table): string
    {
        return match ($table) {
            'pelayanan_kesekerja' => 'uploads/pelkes',
            'sk_p2k3' => 'uploads/p2k3',
            'pelaporan_kk_pak' => 'uploads/kk_pak',
            'pelaporan_p2k3' => 'uploads/laporan_p2k3',
            default => 'uploads/migrated'
        };
    }

    private function uploadToVercelBlob($content, $folder, $filename): ?string
    {
        try {
            $token = env('BLOB_READ_WRITE_TOKEN');
            if (!$token) {
                $this->error("BLOB_READ_WRITE_TOKEN not set!");
                return null;
            }

            // Use Vercel Blob PHP client
            $client = new \VercelBlobPhp\Client($token);

            $pathname = $folder . '/' . uniqid() . '_' . $filename;

            // Determine content type from extension
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            $contentType = match ($ext) {
                'pdf' => 'application/pdf',
                'jpg', 'jpeg' => 'image/jpeg',
                'png' => 'image/png',
                default => 'application/octet-stream'
            };

            $response = $client->put($pathname, $content, [
                'access' => 'public',
                'contentType' => $contentType
            ]);

            return $response['url'] ?? null;

        } catch (\Exception $e) {
            Log::error("Vercel Blob upload failed: " . $e->getMessage());
            return null;
        }
    }
}
