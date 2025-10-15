<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk menambahkan kolom deskripsi.
     */
    public function up(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            if (!Schema::hasColumn('teams', 'deskripsi')) {
                $table->longText('deskripsi')->nullable()->after('jabatan');
            }
        });
    }

    /**
     * Kembalikan perubahan migrasi (hapus kolom deskripsi).
     */
    public function down(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            if (Schema::hasColumn('teams', 'deskripsi')) {
                $table->dropColumn('deskripsi');
            }
        });
    }
};
