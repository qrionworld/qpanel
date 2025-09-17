@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <h2 class="mb-4 text-center">✏️ Edit Settings</h2>

            {{-- Error validation --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>⚠️ {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card shadow-sm rounded">
                <div class="card-body">
                    <form action="{{ route('admin.settings.update') }}" method="POST">
                        @csrf

                        {{-- App Name --}}
                        <div class="mb-3">
                            <label for="app_name" class="form-label fw-bold">📱 App Name</label>
                            <input type="text" name="app_name" id="app_name" 
                                   class="form-control" 
                                   value="{{ old('app_name', $settings['app_name'] ?? '') }}" 
                                   required>
                        </div>

                        {{-- Admin Email --}}
                        <div class="mb-3">
                            <label for="admin_email" class="form-label fw-bold">📧 Admin Email</label>
                            <input type="email" name="admin_email" id="admin_email" 
                                   class="form-control" 
                                   value="{{ old('admin_email', $settings['admin_email'] ?? '') }}" 
                                   required>
                        </div>

                        {{-- Theme --}}
                        <div class="mb-3">
                            <label for="theme" class="form-label fw-bold">🎨 Theme</label>
                            <select name="theme" id="theme" class="form-select">
                                <option value="light" {{ (old('theme', $settings['theme'] ?? '') == 'light') ? 'selected' : '' }}>☀️ Light</option>
                                <option value="dark" {{ (old('theme', $settings['theme'] ?? '') == 'dark') ? 'selected' : '' }}>🌙 Dark</option>
                            </select>
                        </div>

                        {{-- App Version --}}
                        <div class="mb-3">
                            <label for="app_version" class="form-label fw-bold">🔖 App Version</label>
                            <input type="text" name="app_version" id="app_version" 
                                   class="form-control" 
                                   value="{{ old('app_version', $settings['app_version'] ?? '') }}">
                        </div>

                        {{-- Tombol --}}
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.settings.index') }}" class="btn btn-secondary">↩️ Kembali</a>
                            <button type="submit" class="btn btn-success">💾 Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
