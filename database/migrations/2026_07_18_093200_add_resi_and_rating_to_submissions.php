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
        $tables = [
            'pelayanan_kesekerja',
            'sk_p2k3',
            'pelaporan_p2k3',
            'pelaporan_kk_pak'
        ];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                if (!Schema::hasColumn($table->getTable(), 'resi_pengajuan')) {
                    $table->string('resi_pengajuan', 50)->nullable()->unique()->after('id');
                }
                if (!Schema::hasColumn($table->getTable(), 'rating_ikm')) {
                    $table->integer('rating_ikm')->nullable();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = [
            'pelayanan_kesekerja',
            'sk_p2k3',
            'pelaporan_p2k3',
            'pelaporan_kk_pak'
        ];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                if (Schema::hasColumn($table->getTable(), 'resi_pengajuan')) {
                    $table->dropColumn('resi_pengajuan');
                }
                if (Schema::hasColumn($table->getTable(), 'rating_ikm')) {
                    $table->dropColumn('rating_ikm');
                }
            });
        }
    }
};
