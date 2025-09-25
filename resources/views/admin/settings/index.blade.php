@extends('layouts.admin')

@section('content')
<div class="container py-4">
    {{-- Header + Back Button --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">
            <i class="bi bi-gear-fill me-2"></i> Pengaturan
        </h2>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-primary rounded-pill">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
        </a>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            ✅ {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Grid Settings --}}
    <div class="row g-4 justify-content-center">
        @php
            $colors = [
                'app_name'=>'linear-gradient(135deg, #6f42c1, #6610f2)',
                'admin_email'=>'linear-gradient(135deg, #198754, #20c997)',
                'theme'=>'linear-gradient(135deg, #fd7e14, #ffc107)',
                'app_version'=>'linear-gradient(135deg, #0d6efd, #6610f2)'
            ];
        @endphp

        @foreach(['app_name'=>'App Name','admin_email'=>'Admin Email','theme'=>'Theme','app_version'=>'App Version'] as $key=>$label)
        <div class="col-md-5">
            <div class="card shadow-sm border-0 rounded-4 h-100 setting-card card-hover">
                <div class="card-body d-flex align-items-center gap-3">
                    {{-- Icon box --}}
                    <div class="icon-box d-flex align-items-center justify-content-center rounded-circle shadow-sm"
                         style="width:60px; height:60px; background: {{ $colors[$key] }}; color:white; font-size:1.5rem;">
                        @if($key=='app_name') <i class="bi bi-app-indicator"></i>
                        @elseif($key=='admin_email') <i class="bi bi-envelope-fill"></i>
                        @elseif($key=='theme') <i class="bi bi-palette-fill"></i>
                        @elseif($key=='app_version') <i class="bi bi-info-circle-fill"></i>
                        @endif
                    </div>

                    {{-- Setting Content --}}
                    <div>
                        <h6 class="text-muted mb-1">{{ $label }}</h6>
                        <h5 class="fw-bold">
                            {{ $settings->where('key',$key)->first()->value ?? '-' }}
                        </h5>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Edit Button --}}
    <div class="text-center mt-5">
        <a href="{{ route('admin.settings.edit') }}" class="btn btn-lg btn-primary px-5 shadow-sm rounded-pill">
            ✏️ Edit Pengaturan
        </a>
    </div>
</div>

{{-- Custom Style --}}
<style>
    .card-hover {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.2);
    }
    .icon-box {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .icon-box:hover {
        transform: scale(1.1);
        box-shadow: 0 8px 15px rgba(0,0,0,0.2);
    }
</style>
@endsection
