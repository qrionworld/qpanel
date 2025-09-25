@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4">✏️ Edit Profil</h2>

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3 text-center">
                    <img src="{{ $user->photo ? asset('storage/' . $user->photo) : 'https://i.pravatar.cc/150' }}"
                         class="rounded-circle shadow mb-3" width="120" height="120">
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                           class="form-control rounded-pill" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                           class="form-control rounded-pill" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password (opsional)</label>
                    <input type="password" name="password" class="form-control rounded-pill" placeholder="••••••••">
                </div>

                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control rounded-pill" placeholder="••••••••">
                </div>

                <div class="mb-3">
                    <label class="form-label">Foto Profil</label>
                    <input type="file" name="photo" class="form-control">
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.profile.index') }}" class="btn btn-secondary">⬅️ Kembali</a>
                    <button type="submit" class="btn btn-success">💾 Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
