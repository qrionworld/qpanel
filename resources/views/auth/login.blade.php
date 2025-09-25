@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    {{-- Pesan error --}}
    @if($errors->any())
        <div class="alert alert-danger small">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login.process') }}">
        @csrf

        {{-- Email --}}
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email"
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" required autofocus>
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Password --}}
        <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="input-group">
                <input type="password" name="password" id="password"
                       class="form-control @error('password') is-invalid @enderror"
                       required>
                <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                    <i class="bi bi-eye-slash"></i>
                </button>
            </div>
            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Remember --}}
        <div class="mb-3 form-check">
            <input type="checkbox" name="remember" id="remember" class="form-check-input">
            <label for="remember" class="form-check-label">Ingat saya</label>
        </div>

        {{-- Tombol --}}
        <button type="submit" class="btn-auth">
            🔑 Login
        </button>
    </form>
@endsection

@push('scripts')
<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const password = document.getElementById('password');
        const icon = this.querySelector('i');
        if (password.type === "password") {
            password.type = "text";
            icon.classList.replace("bi-eye-slash", "bi-eye");
        } else {
            password.type = "password";
            icon.classList.replace("bi-eye", "bi-eye-slash");
        }
    });
</script>
@endpush
