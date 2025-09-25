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

    // Render partial table (tbody) saja
    return view('admin.content.partials.table', compact('contents'))->render();
}


    public function create()
    {
        $categories = Category::pluck('name');
        return view('admin.content.create', compact('categories'));
    }

    public function store(Request $request)
    {
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

        ActivityLog::create(['activity' => "Buat konten baru: {$content->title}"]);

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

        $category = Category::firstOrCreate(['name' => $request->category]);

        $content->update([
            'title' => $request->title,
            'body' => $request->body,
            'category_id' => $category->id,
        ]);

        // Hapus gambar lama
        if ($request->filled('delete_images')) {
            foreach ($request->delete_images as $imgId) {
                $img = $content->images()->find($imgId);
                if ($img) {
                    Storage::disk('public')->delete($img->path);
                    $img->delete();
                }
            }
        }

        // Tambah gambar baru
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('content_images', 'public');
                $content->images()->create(['path' => $path]);
            }
        }

        ActivityLog::create(['activity' => "Update konten: {$content->title}"]);

        return redirect()->route('admin.content.index')->with('success', 'Konten berhasil diperbarui.');
    }

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
