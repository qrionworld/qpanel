<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
 public function up(): void
{
    Schema::table('settings', function (Blueprint $table) {
        $table->string('app_name')->default('My App');
        $table->string('admin_email')->nullable();
        $table->enum('theme', ['light', 'dark'])->default('light');
        $table->string('app_version')->nullable();
    });
}

public function down(): void
{
    Schema::table('settings', function (Blueprint $table) {
        $table->dropColumn(['app_name', 'admin_email', 'theme', 'app_version']);
    });
}
};
