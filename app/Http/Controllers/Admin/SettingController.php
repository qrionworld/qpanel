<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\ActivityLog;

class SettingController extends Controller
{
    // Index - tampilkan settings
    public function index()
    {
        $settings = Setting::all(); // collection Eloquent
        return view('admin.settings.index', compact('settings'));
    }

    // Edit form
    public function edit()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray(); // untuk form edit lebih gampang akses $settings['app_name']
        return view('admin.settings.edit', compact('settings'));
    }

    // Update settings
    public function update(Request $request)
    {
        $request->validate([
            'app_name'    => 'required|string|max:255',
            'admin_email' => 'required|email',
            'theme'       => 'nullable|in:light,dark',
            'app_version' => 'nullable|string|max:50',
        ]);

        $data = [
            'app_name'    => $request->app_name,
            'admin_email' => $request->admin_email,
            'theme'       => $request->theme ?? 'light',
            'app_version' => $request->app_version,
        ];

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

       ActivityLog::create([
            'activity' => 'Update settings aplikasi',
        ]);

        return redirect()->route('admin.settings.index')->with('success', 'Settings berhasil diperbarui!');
    }
}
