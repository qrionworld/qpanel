<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;


class LoginController extends Controller
{
    // ✅ Tampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // ✅ Proses login

public function login(Request $request)
{
    if (Auth::attempt($request->only('email', 'password'))) {
        ActivityLog::create([
            'activity' => 'Login ke sistem',
        ]);

        // arahkan ke dashboard admin
        return redirect()->route('admin.dashboard')->with('success', 'Login berhasil!');
    }

    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ]);
}


    // ✅ Logout
public function logout(Request $request)
{
    // Simpan log sebelum logout
    ActivityLog::create([
        'activity' => 'Logout dari sistem',
    ]);
    

    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login')->with('success', 'Anda berhasil logout.');
}

}
