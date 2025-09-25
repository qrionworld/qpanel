<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Content;
use App\Models\Setting;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalContents = Content::count();
        $totalSettings = Setting::count();

        return view('admin.dashboard', compact('totalUsers', 'totalContents', 'totalSettings'));
    }
}
