@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="fw-bold mb-4 text-gradient">📊 Dashboard</h1>
    <div class="row g-4">

        {{-- Total Users --}}
<div class="col-md-4">
    <div class="card dashboard-card gradient-blue shadow-lg border-0 rounded-4 h-100">
        <div class="card-body d-flex align-items-center">
            <div class="icon-box me-3">
                <i class="bi bi-people-fill"></i>
            </div>
            <div>
                <h6 class="text-dark-50 mb-1">Total Pengguna</h6>
                <h3 class="fw-bold text-dark">{{ $totalUsers }}</h3>
            </div>
        </div>
    </div>
</div>

{{-- Total Contents --}}
<div class="col-md-4">
    <div class="card dashboard-card gradient-green shadow-lg border-0 rounded-4 h-100">
        <div class="card-body d-flex align-items-center">
            <div class="icon-box me-3">
                <i class="bi bi-file-earmark-text-fill"></i>
            </div>
            <div>
                <h6 class="text-dark-50 mb-1">Total Blog</h6>
                <h3 class="fw-bold text-dark">{{ $totalContents }}</h3>
            </div>
        </div>
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
        --blue: #1D4ED8;
        --yellow: #FACC15;
    }

    /* Gradient text */
    .text-gradient {
        background: linear-gradient(90deg, var(--teal), var(--green));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Card gradients */
    .gradient-blue {
        background: linear-gradient(135deg, var(--blue), #3B82F6);
    }
    .gradient-green {
        background: linear-gradient(135deg, var(--teal), var(--green));
    }
    .gradient-yellow {
        background: linear-gradient(135deg, var(--yellow), #F59E0B);
    }

    /* Dashboard card style */
    .dashboard-card {
        transition: all 0.3s ease;
    }
    .dashboard-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15) !important;
    }

    /* Icon box */
    .icon-box {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        background: rgba(255,255,255,0.2);
        color: #fff;
    }
</style>
@endpush
