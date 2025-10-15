@extends('layouts.admin')

@section('title', 'Edit Profil')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4">✏️ Edit Profil</h2>

    {{-- ✅ Pesan error validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger rounded-3 shadow-sm">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ✅ Pesan sukses --}}
    @if (session('success'))
        <div class="alert alert-success rounded-3 shadow-sm">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-lg border-0 rounded-4 mt-3">
        <div class="card-body p-4">
            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Foto Profil --}}
                <div class="mb-4 text-center">
                    <img src="{{ $user->photo ? asset('storage/' . $user->photo) : 'https://i.pravatar.cc/150' }}"
                         class="rounded-circle shadow mb-3 border border-3 border-light"
                         width="120" height="120" alt="Foto Profil">
                </div>

                {{-- Nama --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama</label>
                    <input type="text" 
                           name="name" 
                           value="{{ old('name', $user->name) }}" 
                           class="form-control rounded-pill @error('name') is-invalid @enderror" 
                           required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" 
                           name="email" 
                           value="{{ old('email', $user->email) }}" 
                           class="form-control rounded-pill @error('email') is-invalid @enderror" 
                           required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password (opsional) --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Password (opsional)</label>
                    <input type="password" 
                           name="password" 
                           class="form-control rounded-pill @error('password') is-invalid @enderror" 
                           placeholder="••••••••">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Kosongkan jika tidak ingin mengganti password</small>
                </div>

                {{-- Foto Profil --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Foto Profil</label>
                    <input type="file" 
                           name="photo" 
                           class="form-control @error('photo') is-invalid @enderror">
                    @error('photo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Format: jpg, jpeg, png. Max 2MB</small>
                </div>

                {{-- Tombol Aksi --}}
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('admin.profile.index') }}" class="btn btn-secondary rounded-pill px-4">
                        ⬅️ Kembali
                    </a>
                    <button type="submit" class="btn btn-success rounded-pill px-4">
                        💾 Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
