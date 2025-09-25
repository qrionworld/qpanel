<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\ActivityLog;

class ProfileController extends Controller
{
    public function index()
    {
 
    $user = Auth::user();
    $lastContent = \App\Models\Content::latest()->first(); // ambil konten terakhir

    return view('admin.profile.index', compact('user', 'lastContent'));
}


    public function edit()
    {
        $user = Auth::user();
        return view('admin.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
            'photo'    => 'nullable|image|mimes:jpg,png,jpeg|max:102400', // 100MB
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('photo')) {
            $user->photo = $request->file('photo')->store('profile', 'public');
        }

        $user->save();

        ActivityLog::create([
            'activity' => "Update profil ({$user->name})",
        ]);

        return redirect()->route('admin.profile.index')
            ->with('success', 'Profil berhasil diperbarui!');
    }
}
