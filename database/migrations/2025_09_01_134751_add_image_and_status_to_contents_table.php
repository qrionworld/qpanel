<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('contents', function (Blueprint $table) {
        if (!Schema::hasColumn('contents', 'image')) {
            $table->string('image')->nullable()->after('body');
        }

        if (!Schema::hasColumn('contents', 'status')) {
            $table->boolean('status')->default(1)->after('image');
        }
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contents', function (Blueprint $table){
            $table->dropColumn('image');
        });
    }
};
