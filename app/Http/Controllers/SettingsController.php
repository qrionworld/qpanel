<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
{
    // Ambil semua data dari tabel settings
    $settings = \App\Models\Setting::all();

    // Ambil tanggal terakhir update
    $lastUpdated = \App\Models\Setting::orderBy('updated_at', 'desc')->value('updated_at');

    return view('admin.settings.index', compact('settings', 'lastUpdated'));
}


    public function edit()
    {
        $settings = Setting::all();
        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        // contoh update, silakan sesuaikan
        foreach ($request->except('_token') as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated!');
    }
}
