<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Content;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat 1 konten contoh
        $content = Content::create([
            'title' => 'Contoh Judul',
            'body' => 'Ini adalah contoh isi konten.',
            'is_published' => 1,
            'category' => 'Umum',
        ]);

        // Tambahkan gambar contoh ke tabel content_images
        $content->images()->create([
            'path' => 'contents/example1.jpg',
        ]);

        $content->images()->create([
            'path' => 'contents/example2.jpg',
        ]);
    }
}
