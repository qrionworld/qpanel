<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::latest()->get();
        return view('admin.team.index', compact('teams'));
    }

    public function create()
    {
        return view('admin.team.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string', // ✅ tambahkan ini
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('team', 'public');
        }

        Team::create($validated);
        return redirect()->route('admin.team.index')->with('success', 'Anggota team berhasil ditambahkan!');
    }

    public function edit(Team $team)
    {
        return view('admin.team.edit', compact('team'));
    }

    public function update(Request $request, Team $team)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string', // ✅ tambahkan ini juga
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($team->foto) {
                Storage::disk('public')->delete($team->foto);
            }
            $validated['foto'] = $request->file('foto')->store('team', 'public');
        }

        $team->update($validated);
        return redirect()->route('admin.team.index')->with('success', 'Data team berhasil diperbarui!');
    }

    public function destroy(Team $team)
    {
        if ($team->foto) {
            Storage::disk('public')->delete($team->foto);
        }
        $team->delete();
        return redirect()->route('admin.team.index')->with('success', 'Anggota team berhasil dihapus!');
    }

    public function show($id)
    {
        $team = Team::findOrFail($id);
        return view('admin.team.show', compact('team'));
    }
}
