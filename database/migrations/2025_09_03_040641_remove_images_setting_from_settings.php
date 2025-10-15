<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Jalankan migration.
     */
    public function up(): void
    {
        // Hapus data dengan key = images
        DB::table('settings')->where('id', 1)->delete();

    }

    /**
     * Rollback migration.
     */
    public function down(): void
    {
        // Jika ingin rollback, bisa insert lagi data kosong
        DB::table('settings')->insert([
            'key'   => 'images',
            'value' => null,
        ]);
    }
};
