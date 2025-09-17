<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil seeder untuk data awal
        $this->call([
            ContentSeeder::class,
            AdminUserSeeder::class, // 🔹 tambahkan ini
        ]);
    }
}
