<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Content;
use App\Models\Setting;
use App\Models\Kegiatan;
use App\Models\Team;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung total semua entitas
        $totalUsers    = User::count();
        $totalContents = Content::count();
        $totalSettings = Setting::count();
        $totalKegiatan = Kegiatan::count();
        $totalTeam     = Team::count();

        // 🔹 Ambil data aktivitas (7 hari terakhir)
        $today = Carbon::today();
        $startDate = $today->copy()->subDays(6); // rentang 7 hari terakhir

        $rawData = Kegiatan::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total')
            )
            ->whereBetween('created_at', [$startDate, $today->endOfDay()])
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        // 🔹 Pastikan semua hari 7 terakhir muncul meski tanpa data
        $activityData = collect();
        for ($i = 0; $i < 7; $i++) {
            $date = $startDate->copy()->addDays($i)->format('Y-m-d');
            $found = $rawData->firstWhere('date', $date);
            $activityData->push([
                'date'  => Carbon::parse($date)->translatedFormat('D'), // tampil 'Sen', 'Sel', dst.
                'total' => $found->total ?? 0
            ]);
        }

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalContents',
            'totalKegiatan',
            'totalTeam',
            'activityData'
        ));
    }
}
