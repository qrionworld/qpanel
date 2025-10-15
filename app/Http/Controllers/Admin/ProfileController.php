<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\ActivityLog;

class ProfileController extends Controller
{
    // ✅ Halaman profil
    public function index()
    {
        $user = Auth::user();
        $lastContent = \App\Models\Content::latest()->first(); // ambil konten terakhir

        return view('admin.profile.index', compact('user', 'lastContent'));
    }

    // ✅ Halaman edit profil
    public function edit()
    {
        $user = Auth::user();
        return view('admin.profile.edit', compact('user'));
    }

    // ✅ Proses update profil
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi input (tanpa confirmed password)
        $rules = [
            'name'  => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'min:6';
        }

        $request->validate($rules);

        // Update nama & email
        $user->name  = $request->name;
        $user->email = $request->email;

        // Update password jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Update foto profil
        if ($request->hasFile('photo')) {
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            $path = $request->file('photo')->store('profile', 'public');
            $user->photo = $path;
        }

        $user->save();

        // Catat ke activity log
        ActivityLog::create([
            'activity' => "Update profil ({$user->name})",
        ]);

        return redirect()->route('admin.profile.index')
            ->with('success', 'Profil berhasil diperbarui!');
    }
}
