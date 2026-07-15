<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tables = ['pelayanan_kesekerja', 'sk_p2k3', 'pelaporan_p2k3', 'pelaporan_kk_pak'];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                // Directly add column, assuming it doesn't exist yet (fresh migration)
                $table->string('file_balasan')->nullable()->after('catatan');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = ['pelayanan_kesekerja', 'sk_p2k3', 'pelaporan_p2k3', 'pelaporan_kk_pak'];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $table) {
                    if (Schema::hasColumn($table->getTable(), 'file_balasan')) {
                        $table->dropColumn('file_balasan');
                    }
                });
            }
        }
    }
};
