<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Content;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ContentResource;

class ContentApiController extends Controller
{
    // GET all contents
    public function index()
    {
        $contents = Content::with('images')->latest()->paginate(10);
        return ContentResource::collection($contents);
    }

    // GET single content
    public function show($id)
    {
        $content = Content::with('images')->findOrFail($id);
        return new ContentResource($content);
    }

    // CREATE content
    public function store(Request $request)
    {
        $request->validate([
            'title'     => 'required|string|max:255',
            'body'      => 'required|string',
            'images.*'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $content = Content::create([
            'title' => $request->title,
            'body'  => $request->body,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('contents', 'public');
                $content->images()->create(['path' => $path]);
            }
        }

        return new ContentResource($content->load('images'));
    }

    // UPDATE content
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'     => 'sometimes|string|max:255',
            'body'      => 'sometimes|string',
            'images.*'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $content = Content::findOrFail($id);

        $content->update($request->only('title', 'body'));

        // hapus gambar jika ada `delete_images`
        if ($request->filled('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $img = $content->images()->find($imageId);
                if ($img) {
                    if (Storage::disk('public')->exists($img->path)) {
                        Storage::disk('public')->delete($img->path);
                    }
                    $img->delete();
                }
            }
        }

        // upload gambar baru
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('contents', 'public');
                $content->images()->create(['path' => $path]);
            }
        }

        return new ContentResource($content->load('images'));
    }

    // DELETE content
    public function destroy($id)
    {
        $content = Content::with('images')->findOrFail($id);

        foreach ($content->images as $img) {
            if (Storage::disk('public')->exists($img->path)) {
                Storage::disk('public')->delete($img->path);
            }
            $img->delete();
        }

        $content->delete();

        return response()->json(['message' => 'Content berhasil dihapus.']);
    }
}
