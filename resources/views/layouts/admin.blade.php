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
            font-family: "Segoe UI", sans-serif;
            transition: background 0.3s, color 0.3s;
        }

        body.dark-mode {
            background: var(--dark);
            color: #f1f1f1;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: linear-gradient(160deg, var(--teal), var(--green));
            color: white;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.2);
            transition: width 0.3s ease;
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px;
        }

        .sidebar-header h4 {
            font-size: 1.2rem;
            margin: 0;
            font-weight: bold;
            color: #fff;
            white-space: nowrap;
        }

        .sidebar.collapsed .sidebar-header h4 {
            display: none;
        }

        .collapse-btn {
            background: none;
            border: none;
            color: white;
            font-size: 1.4rem;
            cursor: pointer;
            transition: transform 0.3s, color 0.3s;
        }

        .collapse-btn:hover {
            transform: rotate(90deg);
            color: #5dc56b;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            margin: 4px 10px;
            color: #cfcfcf;
            text-decoration: none;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .sidebar a i {
            font-size: 1.2rem;
            margin-right: 12px;
            min-width: 25px;
            text-align: center;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
            transform: translateX(5px);
        }

        .sidebar a.active {
            background: #14a09f;
            color: #fff !important;
            box-shadow: 0 2px 10px rgba(20, 160, 159, 0.6);
        }

        .sidebar.collapsed a span {
            display: none;
        }

        .sidebar-footer {
            margin-top: auto;
            padding: 15px;
            text-align: center;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.8);
        }

        /* Navbar */
        .navbar-custom {
            padding: 12px 25px;
            background: rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(12px);
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
            margin-bottom: 15px;
            position: sticky;
            top: 10px;
            z-index: 100;
            transition: background 0.3s ease;
        }

        body.dark-mode .navbar-custom {
            background: rgba(25, 25, 25, 0.7);
        }

        /* Dark Mode Button */
        .btn-darkmode {
            background: linear-gradient(135deg, var(--teal), var(--green));
            border: none;
            color: white;
            padding: 8px 14px;
            border-radius: 50px;
            font-size: 1.1rem;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }

        .btn-darkmode:hover {
            transform: rotate(15deg) scale(1.1);
            box-shadow: 0 5px 12px rgba(0, 0, 0, 0.25);
        }
    </style>
</head>

<body>
    {{-- Sidebar --}}
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h4>⚙️ Admin</h4>
            <button class="collapse-btn" onclick="toggleSidebar()">☰</button>
        </div>

        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-bar-chart"></i><span>Dashboard</span>
        </a>

        <a href="{{ route('admin.content.index') }}" class="{{ request()->routeIs('admin.content.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-text"></i><span>Blog</span>
        </a>

        <div class="sidebar-footer">
            © 2025 Admin Panel
        </div>
    </div>

    {{-- Main Content --}}
    <div class="content flex-grow-1">
 
<!-- Navbar -->
<div class="navbar-custom d-flex justify-content-between align-items-center px-3 shadow-sm">
    <!-- Kiri: bisa kosong atau breadcrumb -->
    <div class="navbar-left">
        <span class="fw-bold">Admin Panel</span>
    </div>

    <!-- Kanan: notifikasi, dark mode, profile/admin -->
    <div class="d-flex align-items-center gap-2 navbar-right">
        <!-- Notifikasi -->
        <div class="dropdown">
            <button class="btn btn-light position-relative rounded-circle shadow-sm p-2" data-bs-toggle="dropdown" title="Notifikasi">
                <i class="bi bi-bell fs-5"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-lg rounded-3" style="width: 300px; max-height: 350px; overflow-y: auto;">
                <li class="dropdown-header fw-bold">🔔 Notifikasi</li>
                @forelse($notifications as $notif)
                <li class="dropdown-item small d-flex flex-column">
                    <span><i class="bi bi-activity text-primary me-2"></i>{{ $notif->activity }}</span>
                    <small class="text-muted">{{ $notif->created_at->diffForHumans() }}</small>
                </li>
                @empty
                <li><span class="dropdown-item small text-muted">Tidak ada notifikasi</span></li>
                @endforelse
                <li><hr class="dropdown-divider"></li>
                <li><a href="{{ route('admin.activity.index') }}" class="dropdown-item text-center">Lihat semua</a></li>
            </ul>
        </div>

        <!-- Profile/Admin -->
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                @if(Auth::user()->photo)
                <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="profile" class="rounded-circle me-2" width="40" height="40">
                @else
                <img src="https://i.pravatar.cc/40?u={{ Auth::user()->email }}" alt="profile" class="rounded-circle me-2" width="40" height="40">
                @endif
                <span class="fw-semibold d-none d-md-inline">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-lg rounded-3">
                <li><a class="dropdown-item" href="{{ route('admin.profile.index') }}"><i class="bi bi-person me-2"></i> Profil</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i> Keluar
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>

<style>
/* Navbar */
.navbar-custom {
    position: sticky;
    top: 0;
    z-index: 1050;
    background: rgba(255,255,255,0.85);
    backdrop-filter: blur(12px);
    border-radius: 12px;
    padding: 8px 16px;
    transition: all 0.3s ease;
}

/* Konten utama agar navbar tidak menutupi */
.content {
    flex-grow: 1;
    padding: 20px;
}

body.dark-mode .navbar-custom {
    background: rgba(25,25,25,0.85);
}

.btn-darkmode {
    background: linear-gradient(135deg, #14a09f, #5dc56b);
    border: none;
    color: white;
    border-radius: 50px;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.btn-darkmode:hover {
    transform: rotate(15deg) scale(1.1);
    box-shadow: 0 5px 12px rgba(0,0,0,0.25);
}

.dropdown-toggle::after { display: none; }
.dropdown-menu { min-width: 220px; }
.dropdown-item:hover { background-color: rgba(20,160,159,0.15); border-radius: 8px; }
</style>


        <hr>
        @yield('content')
    </div>

        <script>
        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");
            sidebar.classList.toggle("collapsed");
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
