@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
        <h1 class="fw-bold">📊 <span class="text-gradient">Dashboard</span></h1>
    </div>

    {{-- Statistik Cards --}}
    <div class="row g-4">
        {{-- Total Pengguna --}}
        <div class="col-md-3 col-sm-6">
            <div class="card stat-card gradient-blue shadow-lg border-0 rounded-4 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box me-3">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-white-50 mb-1">Total Pengguna</h6>
                        <h3 class="fw-bold text-white">{{ $totalUsers }}</h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Blog --}}
        <div class="col-md-3 col-sm-6">
            <div class="card stat-card gradient-green shadow-lg border-0 rounded-4 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box me-3">
                        <i class="bi bi-file-earmark-text-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-white-50 mb-1">Total Blog</h6>
                        <h3 class="fw-bold text-white">{{ $totalContents }}</h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Kegiatan --}}
        <div class="col-md-3 col-sm-6">
            <div class="card stat-card gradient-yellow shadow-lg border-0 rounded-4 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box me-3">
                        <i class="bi bi-calendar-event-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-white-50 mb-1">Total Kegiatan</h6>
                        <h3 class="fw-bold text-white">{{ $totalKegiatan }}</h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Team --}}
        <div class="col-md-3 col-sm-6">
            <div class="card stat-card gradient-purple shadow-lg border-0 rounded-4 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box me-3">
                        <i class="bi bi-person-workspace"></i>
                    </div>
                    <div>
                        <h6 class="text-white-50 mb-1">Total Team</h6>
                        <h3 class="fw-bold text-white">{{ $totalTeam }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Grafik Aktivitas --}}
    <div class="mt-5">
        <div class="card border-0 shadow-lg rounded-4 p-4 glass-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0"><i class="bi bi-bar-chart text-primary me-2"></i>Aktivitas Bulanan</h5>
                <small class="text-muted">Data kegiatan terbaru</small>
            </div>

            <div class="chart-container" style="height: 350px;">
                <canvas id="activityChart" height="120"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
    :root {
        --teal: #14A09F;
        --green: #5DC56B;
        --blue: #2563EB;
        --yellow: #FACC15;
        --purple: #8B5CF6;
        --glass-bg: rgba(255, 255, 255, 0.15);
    }

    /* Gradient text */
    .text-gradient {
        background: linear-gradient(90deg, var(--blue), var(--green));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Gradient Cards */
    .gradient-blue { background: linear-gradient(135deg, var(--blue), #3B82F6); }
    .gradient-green { background: linear-gradient(135deg, var(--teal), var(--green)); }
    .gradient-yellow { background: linear-gradient(135deg, var(--yellow), #F59E0B); }
    .gradient-purple { background: linear-gradient(135deg, var(--purple), #A855F7); }

    /* Card Styling */
    .stat-card {
        position: relative;
        overflow: hidden;
        transition: all 0.35s ease;
        backdrop-filter: blur(10px);
    }

    .stat-card:hover {
        transform: translateY(-6px) scale(1.02);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25) !important;
    }

    /* Icon Box */
    .icon-box {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        color: #fff !important;
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(6px);
        transition: all 0.3s ease;
    }

    .stat-card:hover .icon-box {
        transform: scale(1.1);
        box-shadow: 0 0 12px rgba(255, 255, 255, 0.4);
    }

    /* Glass Card */
    .glass-card {
        background: var(--glass-bg);
        backdrop-filter: blur(12px);
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById('activityChart').getContext('2d');

    // Ambil data dari Controller
    const labels = @json(array_column($activityData->toArray(), 'date'));
    const dataPoints = @json(array_column($activityData->toArray(), 'total'));

    // Buat gradient warna
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(37, 99, 235, 0.6)');
    gradient.addColorStop(1, 'rgba(93, 197, 107, 0.1)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels.length ? labels : ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'],
            datasets: [{
                label: 'Jumlah Aktivitas',
                data: dataPoints.length ? dataPoints : [3, 5, 2, 7, 4, 6, 5],
                fill: true,
                backgroundColor: gradient,
                borderColor: '#2563EB',
                borderWidth: 3,
                tension: 0.35,
                pointBackgroundColor: '#14A09F',
                pointBorderColor: '#fff',
                pointHoverRadius: 6,
                pointRadius: 5,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#2563EB',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: '#93C5FD',
                    borderWidth: 1,
                    displayColors: false,
                    padding: 10,
                    caretPadding: 5,
                }
            },
            scales: {
                x: {
                    ticks: { color: '#6B7280', font: { weight: 600 } },
                    grid: { display: false }
                },
                y: {
                    beginAtZero: true,
                    ticks: { color: '#6B7280' },
                    grid: { color: 'rgba(200,200,200,0.15)' }
                }
            },
            animation: {
                duration: 1000,
                easing: 'easeOutQuart'
            }
        }
    });
});
</script>
@endpush
