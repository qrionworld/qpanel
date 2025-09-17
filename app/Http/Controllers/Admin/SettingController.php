<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    /**
     * Tampilkan daftar setting
     */
    public function index()
{
    // Ambil semua setting kecuali 'images'
    $settings = Setting::where('key', '!=', 'images')->get();

    return view('admin.settings.index', compact('settings'));
}


    /**
     * Form edit setting
     */
    public function edit()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.settings.edit', compact('settings'));
    }

    /**
     * Simpan perubahan setting
     */
    public function update(Request $request)
    {
        $request->validate([
            'app_name'     => 'required|string|max:255',
            'admin_email'  => 'required|email',
            'theme'        => 'nullable|in:light,dark',
            'app_version'  => 'nullable|string|max:50',
        ]);

        $settings = Setting::all()->keyBy('key');

        $data = [
            'app_name'    => $request->app_name,
            'admin_email' => $request->admin_email,
            'theme'       => $request->theme ?? 'light',
            'app_version' => $request->app_version,
        ];

        foreach ($data as $key => $value) {
            $setting = $settings->get($key);
            if ($setting) {
                $setting->update(['value' => $value]);
            } else {
                Setting::create(['key' => $key, 'value' => $value]);
            }
        }

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated!');
    }
}
