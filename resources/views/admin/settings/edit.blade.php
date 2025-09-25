@extends('layouts.admin')

@section('content')
<div class="container py-4">

    {{-- Header + Back --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-gradient" style="background: linear-gradient(160deg, var(--teal), var(--green));-webkit-background-clip: text;-webkit-text-fill-color: transparent;">
            ✏️ Edit Pengaturan
        </h2>
        <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-light rounded-pill shadow-sm hover-scale">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    {{-- Error Message --}}
    @if ($errors->any())
        <div class="alert alert-danger shadow-sm">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Card --}}
    <div class="card shadow-lg rounded-4 hover-lift border-0" style="background: linear-gradient(160deg, var(--teal), var(--green));">
        <div class="card-body">
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="app_name" class="form-label fw-bold text-white">📱 App Name</label>
                    <input type="text" name="app_name" id="app_name" class="form-control form-control-lg shadow-sm hover-input" 
                        value="{{ old('app_name', $settings['app_name'] ?? '') }}" required>
                </div>

                <div class="mb-4">
                    <label for="admin_email" class="form-label fw-bold text-white">📧 Admin Email</label>
                    <input type="email" name="admin_email" id="admin_email" class="form-control form-control-lg shadow-sm hover-input" 
                        value="{{ old('admin_email', $settings['admin_email'] ?? '') }}" required>
                </div>

                <div class="mb-4">
                    <label for="theme" class="form-label fw-bold text-white">🎨 Theme</label>
                    <select name="theme" id="theme" class="form-select form-select-lg shadow-sm hover-input" onchange="changeThemePreview()">
                        <option value="light" {{ (old('theme', $settings['theme'] ?? '')=='light') ? 'selected':'' }}>☀️ Light</option>
                        <option value="dark" {{ (old('theme', $settings['theme'] ?? '')=='dark') ? 'selected':'' }}>🌙 Dark</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="app_version" class="form-label fw-bold text-white">🔖 App Version</label>
                    <input type="text" name="app_version" id="app_version" class="form-control form-control-lg shadow-sm hover-input" 
                        value="{{ old('app_version', $settings['app_version'] ?? '') }}">
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-light rounded-pill px-4 shadow-sm hover-scale">
                        ↩️ Kembali
                    </a>
                    <button type="submit" class="btn btn-light rounded-pill px-4 shadow-sm hover-scale text-success">
                        💾 Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Custom Styles --}}
<style>
    .form-control-lg, .form-select-lg {
        border-radius: 12px;
        transition: transform 0.2s, box-shadow 0.2s, background 0.3s, color 0.3s;
    }

    .hover-input:focus {
        transform: scale(1.03);
        box-shadow: 0 6px 20px rgba(255, 255, 255, 0.35);
        border-color: #fff;
        background: rgba(255,255,255,0.8);
        color: #333;
    }

    .hover-scale {
        transition: transform 0.2s, box-shadow 0.2s, background 0.3s;
    }

    .hover-scale:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 18px rgba(0,0,0,0.35);
    }

    .hover-lift {
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .hover-lift:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.2);
    }

    .text-gradient {
        font-size: 2rem;
        font-weight: 700;
    }
</style>

{{-- Theme Preview Script --}}
<script>
    function changeThemePreview() {
        const theme = document.getElementById('theme').value;
        if(theme === 'dark') {
            document.body.classList.add('dark-mode');
        } else {
            document.body.classList.remove('dark-mode');
        }
    }

    document.addEventListener('DOMContentLoaded', function(){
        changeThemePreview();
    });
</script>
@endsection
