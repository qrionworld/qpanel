<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Category;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    // ✅ Menampilkan daftar konten dengan filter & pencarian
    public function index(Request $request)
    {
        $query = Content::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%");
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $contents = $query->with('category', 'images')->latest()->paginate(10);
        $categories = Category::all();

        return view('admin.content.index', compact('contents', 'categories'));
    }

    // ✅ AJAX search untuk refresh tabel saja
    public function ajaxSearch(Request $request)
    {
        $query = Content::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%");
        }
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $contents = $query->with('category','images')->latest()->paginate(10);

        return view('admin.content.partials.table', compact('contents'))->render();
    }

    // ✅ Halaman form tambah konten
    public function create()
    {
        $categories = Category::pluck('name');
        return view('admin.content.create', compact('categories'));
    }

    // ✅ Proses simpan konten baru
    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'body'         => 'required|string',
            'images.*'     => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'category'     => 'nullable|string|max:100',
            'new_category' => 'nullable|string|max:255',
        ]);

        // 🔹 Pilih kategori: pakai kategori baru kalau ada, kalau tidak pakai yang lama
        $categoryName = $request->new_category ?: $request->category;

        if (!$categoryName) {
            return back()->withErrors(['category' => 'Kategori wajib dipilih atau ditambahkan.'])->withInput();
        }

        // 🔹 Buat kategori baru kalau belum ada
        $category = Category::firstOrCreate(['name' => $categoryName]);

        // 🔹 Simpan konten
        $content = Content::create([
            'title'       => $request->title,
            'body'        => $request->body,
            'category_id' => $category->id,
        ]);

        // 🔹 Simpan gambar kalau ada
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('uploads/content', 'public');
                $content->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('admin.content.index')->with('success', 'Konten berhasil ditambahkan!');
    }

    // ✅ Detail konten
    public function show($id)
    {
        $content = Content::with(['category','images'])->findOrFail($id);
        return view('admin.content.show', compact('content'));
    }

    // ✅ Form edit konten
    public function edit($id)
    {
        $content = Content::with('images','category')->findOrFail($id);
        $categories = Category::pluck('name');
        return view('admin.content.edit', compact('content','categories'));
    }

    // ✅ Update konten
    public function update(Request $request, Content $content)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'body'         => 'required|string',
            'images.*'     => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'category'     => 'nullable|string|max:100',
            'new_category' => 'nullable|string|max:255',
        ]);

        // 🔹 Pilih kategori: pakai kategori baru kalau ada, kalau tidak pakai yang lama
        $categoryName = $request->new_category ?: $request->category;

        if (!$categoryName) {
            return back()->withErrors(['category' => 'Kategori wajib dipilih atau ditambahkan.'])->withInput();
        }

        // 🔹 Buat kategori baru kalau belum ada
        $category = Category::firstOrCreate(['name' => $categoryName]);

        // 🔹 Update data konten
        $content->update([
            'title'       => $request->title,
            'body'        => $request->body,
            'category_id' => $category->id,
        ]);

        // 🔹 Hapus gambar lama kalau dipilih
        if ($request->filled('delete_images')) {
            foreach ($request->delete_images as $imgId) {
                $img = $content->images()->find($imgId);
                if ($img) {
                    Storage::disk('public')->delete($img->path);
                    $img->delete();
                }
            }
        }

        // 🔹 Tambahkan gambar baru
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('content_images', 'public');
                $content->images()->create(['path' => $path]);
            }
        }

        ActivityLog::create(['activity' => "Update konten: {$content->title}"]);

        return redirect()->route('admin.content.index')->with('success', 'Konten berhasil diperbarui.');
    }

    // ✅ Hapus konten
    public function destroy($id)
    {
        $content = Content::findOrFail($id);

        if ($content->images) {
            foreach ($content->images as $img) {
                Storage::disk('public')->delete($img->path);
            }
        }

        $title = $content->title;
        $content->delete();

        ActivityLog::create(['activity' => "Hapus konten: {$title}"]);

        return redirect()->route('admin.content.index')->with('success', 'Konten berhasil dihapus.');
    }
}
