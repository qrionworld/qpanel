<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kegiatan;
use Illuminate\Support\Facades\Storage;

class KegiatanController extends Controller
{
    public function index()
    {
        $kegiatan = Kegiatan::latest()->get();
        return view('admin.kegiatan.index', compact('kegiatan'));
    }

    public function create()
    {
        return view('admin.kegiatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|max:2048',
            'tanggal' => 'required|date',
        ]);

        $data = $request->only(['judul', 'deskripsi', 'tanggal']);

        // ✅ Upload foto bila ada
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('kegiatan', 'public');
        }

        // ✅ Simpan data
        Kegiatan::create($data);

        return redirect()
            ->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan berhasil ditambahkan!');
    }

    public function edit(Kegiatan $kegiatan)
    {
        return view('admin.kegiatan.edit', compact('kegiatan'));
    }

    public function update(Request $request, Kegiatan $kegiatan)
{
    $request->validate([
        'judul' => 'required|string|max:255',
        'deskripsi' => 'required|string',
        'tanggal' => 'required|date',
        'foto.*' => 'nullable|image|max:2048', // max 2MB per file
    ]);

    $data = $request->only(['judul', 'deskripsi', 'tanggal']);
    $existingPhotos = json_decode($kegiatan->foto, true) ?? [];

    // ✅ Hapus foto lama jika dicentang
    if ($request->has('hapus_foto')) {
        foreach ($existingPhotos as $oldPhoto) {
            if (Storage::disk('public')->exists($oldPhoto)) {
                Storage::disk('public')->delete($oldPhoto);
            }
        }
        $existingPhotos = [];
    }

    // ✅ Upload foto baru (bisa banyak)
    if ($request->hasFile('foto')) {
        foreach ($request->file('foto') as $file) {
            $path = $file->store('kegiatan', 'public');
            $existingPhotos[] = $path;
        }
    }

    // Simpan semua foto ke kolom JSON
    $data['foto'] = json_encode($existingPhotos);

    $kegiatan->update($data);

    return redirect()
        ->route('admin.kegiatan.index')
        ->with('success', 'Kegiatan berhasil diperbarui!');
}
    


    public function destroy(Kegiatan $kegiatan)
    {
        // ✅ Hapus foto jika ada
        if ($kegiatan->foto && Storage::disk('public')->exists($kegiatan->foto)) {
            Storage::disk('public')->delete($kegiatan->foto);
        }

        $kegiatan->delete();

        return redirect()
            ->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan berhasil dihapus!');
    }

    public function show($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        return view('admin.kegiatan.show', compact('kegiatan'));
    }
}
