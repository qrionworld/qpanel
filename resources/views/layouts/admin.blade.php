<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>

    {{-- Bootstrap & Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            --teal: #14A09F;
            --green: #5DC56B;
            --dark: #121212;
            --light: #f8f9fa;
        }

        body {
            display: flex;
            min-height: 100vh;
            background: var(--light);
            transition: background 0.3s, color 0.3s;
            font-family: "Segoe UI", sans-serif;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: linear-gradient(160deg, var(--teal), var(--green));
            color: white;
            flex-shrink: 0;
            transition: width 0.3s ease, background 0.3s ease;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 8px rgba(0,0,0,0.2);
        }
        .sidebar.collapsed { width: 70px; }

        .sidebar-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px;
        }
        .sidebar-header h4 {
            font-size: 1.2rem;
            margin: 0;
            white-space: nowrap;
            font-weight: bold;
        }
        .sidebar.collapsed .sidebar-header h4 { display: none; }

        .collapse-btn {
            background: none;
            border: none;
            color: white;
            font-size: 1.4rem;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .collapse-btn:hover { transform: rotate(90deg); }

        .sidebar a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.15);
            padding-left: 25px;
        }
        .sidebar i {
            font-size: 1.2rem;
            margin-right: 10px;
            min-width: 25px;
            text-align: center;
        }
        .sidebar.collapsed a span { display: none; }

        /* Sidebar footer */
        .sidebar-footer {
            margin-top: auto;
            font-size: 0.9rem;
            color: rgba(255,255,255,0.9);
            text-align: center;
            padding: 15px;
        }
        .sidebar-footer hr {
            border-color: rgba(255,255,255,0.3);
        }
        .sidebar.collapsed .sidebar-footer span { display: none; }

        /* Content */
        .content {
            flex-grow: 1;
            padding: 25px;
            background: linear-gradient(135deg, #fdfdfd, #f3f8f7);
            transition: margin-left 0.3s ease, background 0.3s ease;
        }

        /* Navbar */
        .navbar-custom {
            padding: 10px 20px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }
        .btn-darkmode {
            background: linear-gradient(90deg, var(--teal), var(--green));
            border: none;
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            transition: all 0.3s;
        }
        .btn-darkmode:hover {
            background: linear-gradient(90deg, var(--green), var(--teal));
            transform: scale(1.05);
        }

        /* Dark mode */
        body.dark-mode {
            background: var(--dark);
            color: #eaeaea;
        }
        body.dark-mode .content {
            background: linear-gradient(135deg, #1b1b1b, #2a2a2a);
            color: white;
        }
        body.dark-mode .sidebar {
            background: linear-gradient(160deg, #0d5c5b, #3b8f3d);
        }
        body.dark-mode .btn-darkmode {
            background: linear-gradient(90deg, #3b8f3d, #0d5c5b);
        }

        /* Card modern */
        .card-modern {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: transform 0.2s ease;
        }
        .card-modern:hover { transform: translateY(-5px); }

        /* Gradient button */
        .btn-gradient {
            background: linear-gradient(90deg, var(--teal), var(--green));
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            transition: all 0.3s ease;
        }
        .btn-gradient:hover {
            background: linear-gradient(90deg, var(--green), var(--teal));
            transform: translateY(-2px);
            color: #fff;
        }

        /* Table header */
        .table-gradient { background: linear-gradient(90deg, var(--teal), var(--green)); }
    </style>
</head>
<body>
    {{-- Sidebar --}}
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h4>⚙️ Admin</h4>
            <button class="collapse-btn" onclick="toggleSidebar()">☰</button>
        </div>

        <a href="{{ route('admin.dashboard') }}">
            <i class="bi bi-bar-chart"></i><span>Dashboard</span>
        </a>
        <a href="{{ route('admin.content.index') }}">
            <i class="bi bi-file-earmark-text"></i><span>Blog</span>
        </a>
        <a href="{{ route('admin.settings.index') }}">
            <i class="bi bi-gear"></i><span>Pengaturan</span>
        </a>

        {{-- Footer Sidebar --}}
        <div class="sidebar-footer">
            <hr>
            <div class="d-flex align-items-center justify-content-center">
                <i class="bi bi-person-circle fs-4 me-2"></i>
                <span class="fw-semibold">Administrator</span>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="content">
        <div class="navbar-custom">
            <button id="darkModeBtn" class="btn btn-sm btn-darkmode" onclick="toggleDarkMode()">🌙</button>
        </div>
        <hr>
        @yield('content')
    </div>

    {{-- Script utama --}}
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('collapsed');
        }

        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
            const btn = document.getElementById("darkModeBtn");

            if (document.body.classList.contains('dark-mode')) {
                localStorage.setItem('theme', 'dark');
                btn.innerHTML = "☀️";
            } else {
                localStorage.setItem('theme', 'light');
                btn.innerHTML = "🌙";
            }
        }

        document.addEventListener("DOMContentLoaded", function () {
            const btn = document.getElementById("darkModeBtn");
            if (localStorage.getItem('theme') === 'dark') {
                document.body.classList.add('dark-mode');
                btn.innerHTML = "☀️";
            } else {
                document.body.classList.remove('dark-mode');
                btn.innerHTML = "🌙";
            }
        });
    </script>

    {{-- Scripts tambahan per halaman (misalnya Quill, Chart.js, dll) --}}
    @yield('scripts')
</body>
</html>
