@extends('layouts.auth')

@section('title', 'Login')

@section('content')

    {{-- Pesan error --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form login --}}
    <form method="POST" action="{{ route('login.process') }}">
        @csrf

        {{-- Input email --}}
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input 
                id="email" 
                type="email" 
                name="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}" 
                required 
                autofocus
            >
            @error('email')
                <span class="text-danger small">{{ $message }}</span>
            @enderror
        </div>

        {{-- Input password --}}
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
                <input 
                    id="password" 
                    type="password" 
                    name="password"
                    class="form-control @error('password') is-invalid @enderror" 
                    required
                >
                <button 
                    class="btn btn-outline-secondary" 
                    type="button" 
                    id="togglePassword"
                >
                    <i class="bi bi-eye-slash"></i>
                </button>
            </div>
            @error('password')
                <span class="text-danger small">{{ $message }}</span>
            @enderror
        </div>

        {{-- Remember me --}}
        <div class="mb-3 form-check">
            <input 
                class="form-check-input" 
                type="checkbox" 
                name="remember" 
                id="remember"
            >
            <label class="form-check-label" for="remember">
                Ingat saya
            </label>
        </div>

        {{-- Tombol submit --}}
        <button type="submit" class="btn btn-primary w-100 shadow-sm">
            🔑 Login
        </button>
    </form>

    {{-- Toggle password script --}}
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

@endsection
