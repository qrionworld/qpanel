<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Authentication') - Qrion</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #f8fcfa;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .auth-container {
            display: flex;
            gap: 40px;
            width: 90%;
            max-width: 1100px;
            align-items: center;
        }

        /* Bagian gambar */
        .auth-images {
            flex: 1;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        .auth-images img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        .auth-images img.large {
            grid-column: span 2;
            height: 230px;
        }

        /* Box login/register */
        .auth-box {
            flex: 1;
            background: #fff;
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        }
        .auth-box .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .auth-box .logo img {
            width: 150px;
        }

        .form-control {
            border-radius: 8px;
        }

        .btn-auth {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            background: #0d6efd;
            color: #fff;
            transition: 0.3s;
        }
        .btn-auth:hover {
            background: #0b5ed7;
        }

        @media (max-width: 900px) {
            .auth-container {
                flex-direction: column;
            }
            .auth-images {
                grid-template-columns: 1fr;
            }
            .auth-images img.large {
                grid-column: span 1;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        {{-- Bagian gambar --}}
        <div class="auth-images">
            <img src="{{ asset('assets/payday.png') }}" alt="Payday">
            <img src="{{ asset('assets/payment.png') }}" alt="Payment">
            <img src="{{ asset('assets/schedule.png') }}" alt="Schedule" class="large">
        </div>

        {{-- Bagian form --}}
        <div class="auth-box">
            <div class="logo">
                <img src="{{ asset('assets/logo-qrion.png') }}" alt="Qrion Logo">
            </div>

            @yield('content')
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
