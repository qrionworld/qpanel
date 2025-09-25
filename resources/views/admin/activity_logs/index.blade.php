@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">
            <i class="bi bi-activity"></i> Aktivitas User
        </h2>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-primary rounded-pill">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
        </a>
    </div>

    {{-- 🔔 Flash Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
            ✅ {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Card aktivitas --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-light fw-bold">
            Daftar Aktivitas
        </div>
        <div class="card-body p-0">
            @if($logs->count() > 0)
                <ul class="list-group list-group-flush">
                    @foreach($logs as $log)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="bi bi-activity text-primary me-2"></i>
                                {{ $log->activity }}
                            </div>
                            <div class="text-muted small">{{ $log->created_at->diffForHumans() }}</div>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-center text-muted m-3">Belum ada aktivitas.</p>
            @endif
        </div>
    </div>
</div>

{{-- Custom Style --}}
<style>
    .card-header {
        font-size: 1rem;
    }
    .list-group-item i {
        font-size: 1.1rem;
    }
    .list-group-item:hover {
        background-color: rgba(20, 160, 159, 0.05);
        transition: background 0.2s;
    }
</style>
@endsection
