<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    public function index(Request $request)
{
    // Ambil query Content dengan relasi Category & Images
    $query = Content::with(['category', 'images'])->latest();

    // Filter berdasarkan kategori_id
    if ($request->filled('category')) {
        $query->where('category_id', $request->category);
    }

    // Ambil data paginasi
    $contents = $query->paginate(10);

    // Ambil semua kategori dari tabel categories
    $categories = Category::all();

    return view('admin.content.index', compact('contents', 'categories'));
}


    public function create()
    {
        $categories = Category::pluck('name');
        return view('admin.content.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // 👉 untuk debug, pastikan request masuk
        // dd($request->all());

        $request->validate([
            'title' => 'required|string',
            'category' => 'required|string',
            'body' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'
        ]);

        $category = Category::firstOrCreate(['name' => $request->category]);

        $content = Content::create([
            'title' => $request->title,
            'category_id' => $category->id,
            'body' => $request->body,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('content_images', 'public');
                $content->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('admin.content.index')->with('success', 'Konten berhasil ditambahkan!');
    }

        public function show($id)
{
    $content = Content::with(['category','images'])->findOrFail($id);
    return view('admin.content.show', compact('content'));
}

public function edit($id)
{
    $content = Content::with('images','category')->findOrFail($id);
    $categories = Category::pluck('name');
    return view('admin.content.edit', compact('content','categories'));
}

public function update(Request $request, Content $content)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'category' => 'required|string|max:100',
        'body' => 'required|string',
    ]);

    // Cari kategori atau buat baru
    $category = Category::firstOrCreate(['name' => $request->category]);

    // Update data utama
    $content->update([
        'title' => $request->title,
        'body' => $request->body,
        'category_id' => $category->id,
    ]);

    // 🔹 Hapus gambar lama yang dipilih user
    if ($request->filled('delete_images')) {
        foreach ($request->delete_images as $imgId) {
            $img = $content->images()->find($imgId);
            if ($img) {
                \Storage::disk('public')->delete($img->path);
                $img->delete();
            }
        }
    }

    // 🔹 Simpan gambar baru (kalau ada)
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('contents', 'public');
            $content->images()->create(['path' => $path]);
        }
    }

    return redirect()->route('admin.content.index')->with('success', 'Konten berhasil diperbarui.');
}

    public function destroy($id)
{
    $content = Content::findOrFail($id);

    // hapus semua gambar jika ada
    if ($content->images) {
        foreach (json_decode($content->images, true) as $img) {
            \Storage::disk('public')->delete($img);
        }
    }

    $content->delete();

    return redirect()->route('admin.content.index')
                     ->with('success', 'Konten berhasil dihapus.');
}




}
