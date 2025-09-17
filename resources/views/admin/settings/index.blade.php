@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4 text-center">
        <i class="bi bi-gear-fill me-2 text-teal"></i> Pengaturan
    </h2>

    {{-- Notifikasi sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            ✅ {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4 justify-content-center">
        {{-- App Name --}}
        <div class="col-md-5">
            <div class="card shadow-lg border-0 rounded-4 h-100 setting-card">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box me-3 bg-gradient-primary">
                        <i class="bi bi-app-indicator"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">App Name</h6>
                        <h5 class="fw-bold">{{ $settings->where('key','app_name')->first()->value ?? '-' }}</h5>
                    </div>
                </div>
            </div>
        </div>

        {{-- Admin Email --}}
        <div class="col-md-5">
            <div class="card shadow-lg border-0 rounded-4 h-100 setting-card">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box me-3 bg-gradient-info">
                        <i class="bi bi-envelope-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Admin Email</h6>
                        <h5 class="fw-bold">{{ $settings->where('key','admin_email')->first()->value ?? '-' }}</h5>
                    </div>
                </div>
            </div>
        </div>

        {{-- Theme --}}
        <div class="col-md-5">
            <div class="card shadow-lg border-0 rounded-4 h-100 setting-card">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box me-3 bg-gradient-success">
                        <i class="bi bi-palette-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Theme</h6>
                        <h5 class="fw-bold">{{ ucfirst($settings->where('key','theme')->first()->value ?? '-') }}</h5>
                    </div>
                </div>
            </div>
        </div>

        {{-- App Version --}}
        <div class="col-md-5">
            <div class="card shadow-lg border-0 rounded-4 h-100 setting-card">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box me-3 bg-gradient-warning">
                        <i class="bi bi-box-seam-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">App Version</h6>
                        <h5 class="fw-bold">{{ $settings->where('key','app_version')->first()->value ?? '-' }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tombol Edit --}}
    <div class="text-center mt-4">
        <a href="{{ route('admin.settings.edit') }}" class="btn btn-lg btn-primary px-4 shadow-sm">
            ✏️ Edit Pengaturan
        </a>
    </div>
</div>
@endsection

@push('styles')
<style>
    .icon-box {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #fff;
    }
    .bg-gradient-primary {
        background: linear-gradient(135deg, #14A09F, #5DC56B);
    }
    .bg-gradient-info {
        background: linear-gradient(135deg, #17a2b8, #0dcaf0);
    }
    .bg-gradient-success {
        background: linear-gradient(135deg, #5DC56B, #28a745);
    }
    .bg-gradient-warning {
        background: linear-gradient(135deg, #ffc107, #fd7e14);
    }

    /* 🌙 Dark Mode */
    body.dark-mode {
        background-color: #121212 !important;
        color: #f1f1f1 !important;
    }
    body.dark-mode .card.setting-card {
        background-color: #1e1e1e;
        color: #fff;
        border: 1px solid #2d2d2d;
    }
    body.dark-mode h6.text-muted {
        color: #aaa !important;
    }
    body.dark-mode .btn-primary {
        background-color: #14A09F;
        border-color: #14A09F;
    }
</style>
@endpush
