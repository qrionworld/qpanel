@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">
            <i class="bi bi-person-circle"></i> Profil Saya
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

    {{-- Card Profil Utama --}}
    <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-4">
        <div class="bg-gradient position-relative" 
             style="height: 160px; background: linear-gradient(135deg, #6f42c1, #6610f2);">
            <div class="position-absolute top-0 start-0 w-100 h-100"
                 style="backdrop-filter: blur(2px); opacity:0.15;"></div>
        </div>

        <div class="card-body text-center position-relative">
            {{-- Foto Profil --}}
            <div class="position-absolute top-0 start-50 translate-middle">
                <img src="{{ $user->photo ? asset('storage/' . $user->photo) : 'https://i.pravatar.cc/150' }}"
                     class="rounded-circle border border-4 border-white shadow-lg profile-img"
                     width="130" height="130" alt="Foto Profil">
            </div>

            <div class="mt-5">
                {{-- Nama & Email --}}
                <h3 class="fw-bold mb-0">{{ $user->name }}</h3>
                <p class="text-muted mb-1">{{ $user->email }}</p>

                <div class="d-flex justify-content-center gap-3 mt-3">
                    <a href="{{ route('admin.profile.edit') }}" class="btn btn-warning rounded-pill px-4 shadow-sm">
                        <i class="bi bi-pencil-square"></i> Edit Profil
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger rounded-pill px-4 shadow-sm">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Grid Card Informasi --}}
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 h-100 card-hover">
                <div class="card-body text-center">
                    <i class="bi bi-shield-lock text-primary fs-2 mb-2"></i>
                    <h6 class="fw-bold">Role</h6>
                    <p class="text-muted mb-0">{{ $user->role ?? 'Admin' }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 h-100 card-hover">
                <div class="card-body text-center">
                    <i class="bi bi-calendar-check text-success fs-2 mb-2"></i>
                    <h6 class="fw-bold">Dibuat Pada</h6>
                    <p class="text-muted mb-0">{{ $user->created_at->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 h-100 card-hover">
                <div class="card-body text-center">
                    <i class="bi bi-clock-history text-warning fs-2 mb-2"></i>
                    <h6 class="fw-bold">Aktivitas Terakhir</h6>
                    <p class="text-muted mb-0">{{ $user->updated_at->diffForHumans() }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Aktivitas User Terakhir --}}
    <div class="card shadow-sm border-0 rounded-4 mt-4">
        <div class="card-header bg-light fw-bold">
            <i class="bi bi-activity me-2"></i> Aktivitas Terakhir
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-box-arrow-in-right text-primary me-2"></i> Login terakhir</span>
                    <span class="text-muted small">
                        {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Belum pernah login' }}
                    </span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-pencil text-success me-2"></i> Update profil</span>
                    <span class="text-muted small">{{ $user->updated_at->diffForHumans() }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-file-earmark-text text-warning me-2"></i> Konten terakhir dibuat</span>
                    <span class="text-muted small">
                        {{ $lastContent ? $lastContent->created_at->diffForHumans() : 'Belum ada konten' }}
                    </span>
                </li>
            </ul>
        </div>
    </div>
</div>

{{-- 🔥 Custom Style --}}
<style>
    .profile-img {
        transition: 0.3s;
    }
    .profile-img:hover {
        transform: scale(1.05);
        box-shadow: 0 0 15px rgba(111, 66, 193, 0.6);
    }
    .card-hover {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .card-hover:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    }
</style>
@endsection
