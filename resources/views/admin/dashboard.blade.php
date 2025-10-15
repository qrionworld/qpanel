@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h1 class="fw-bold mb-0">📊 <span class="text-gradient">Dashboard</span></h1>
    </div>

    <div class="row g-4">

        {{-- Total Users --}}
        <div class="col-md-4">
            <div class="card dashboard-card glass-effect border-0 rounded-4 shadow-lg h-100 p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-box me-3 bg-gradient-blue">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-secondary mb-1">Total Pengguna</h6>
                        <h3 class="fw-bold mb-0">{{ $totalUsers }}</h3>
                    </div>
                </div>
                <div class="progress mt-3" style="height: 6px;">
                    <div class="progress-bar bg-primary" style="width: {{ $totalUsers > 0 ? '100%' : '50%' }}"></div>
                </div>
            </div>
        </div>

        {{-- Total Blog --}}
        <div class="col-md-4">
            <div class="card dashboard-card glass-effect border-0 rounded-4 shadow-lg h-100 p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-box me-3 bg-gradient-green">
                        <i class="bi bi-file-earmark-text-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-secondary mb-1">Total Blog</h6>
                        <h3 class="fw-bold mb-0">{{ $totalContents }}</h3>
                    </div>
                </div>
                <div class="progress mt-3" style="height: 6px;">
                    <div class="progress-bar bg-success" style="width: {{ $totalContents > 0 ? '100%' : '50%' }}"></div>
                </div>
            </div>
        </div>

        {{-- Example placeholder for future stats --}}
        <div class="col-md-4">
            <div class="card dashboard-card glass-effect border-0 rounded-4 shadow-lg h-100 p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-box me-3 bg-gradient-yellow">
                        <i class="bi bi-bar-chart-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-secondary mb-1">Aktivitas Sistem</h6>
                        <h3 class="fw-bold mb-0">Live</h3>
                    </div>
                </div>
                <div class="small text-muted mt-2">Pemantauan berjalan lancar</div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('styles')
<style>
    :root {
        --teal: #14A09F;
        --green: #5DC56B;
        --blue: #2563EB;
        --yellow: #FACC15;
        --white-glass: rgba(255, 255, 255, 0.25);
        --backdrop: rgba(255, 255, 255, 0.15);
    }

    .text-gradient {
        background: linear-gradient(90deg, var(--blue), var(--green));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Glass effect */
    .glass-effect {
        background: var(--white-glass);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.18);
        transition: all 0.3s ease;
    }
    .glass-effect:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }

    /* Icon styles */
    .icon-box {
        width: 65px;
        height: 65px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        color: #fff;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }

    /* Gradient backgrounds for icons */
    .bg-gradient-blue {
        background: linear-gradient(135deg, var(--blue), #3B82F6);
    }
    .bg-gradient-green {
        background: linear-gradient(135deg, var(--teal), var(--green));
    }
    .bg-gradient-yellow {
        background: linear-gradient(135deg, var(--yellow), #F59E0B);
    }

    /* Animate card load */
    .dashboard-card {
        animation: fadeInUp 0.6s ease;
    }

    @keyframes fadeInUp {
        0% {
            opacity: 0;
            transform: translateY(10px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush
