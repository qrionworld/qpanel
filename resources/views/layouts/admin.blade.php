<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    @stack('styles')

    <style>
        :root {
            --teal: #14A09F;
            --green: #5DC56B;
            --light: #f8fafc;
            --gradient: linear-gradient(135deg, var(--teal), var(--green));
        }

        body {
            display: flex;
            min-height: 100vh;
            font-family: "Inter", "Segoe UI", sans-serif;
            color: #222;
            background: #f3f4f6;
            overflow-x: hidden;
        }

        /* ========== SIDEBAR ========== */
        .sidebar {
            width: 250px;
            background: var(--gradient);
            color: #fff;
            display: flex;
            flex-direction: column;
            border-top-right-radius: 20px;
            border-bottom-right-radius: 20px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);
            transition: width 0.3s ease;
            z-index: 1000;
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar-header {
            padding: 20px;
            font-weight: 700;
            font-size: 1.2rem;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }

        .sidebar a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            margin: 6px 12px;
            border-radius: 10px;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.25s ease;
        }

        .sidebar a i {
            font-size: 1.3rem;
            margin-right: 12px;
            min-width: 25px;
            text-align: center;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
        }

        .sidebar a.active {
            background: rgba(255, 255, 255, 0.25);
            box-shadow: 0 0 10px rgba(255,255,255,0.3);
        }

        .sidebar-footer {
            margin-top: auto;
            padding: 15px;
            font-size: 0.85rem;
            opacity: 0.9;
            text-align: center;
        }

        /* ========== MAIN CONTENT ========== */
        .content {
            flex-grow: 1;
            padding: 30px;
            background: #f9fafb;
            transition: all 0.4s ease;
            z-index: 1;
        }

        /* ========== NAVBAR ========== */
        .navbar-custom {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(16px);
            border-radius: 16px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
            padding: 12px 24px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 10;
        }

        .navbar-custom h5 {
            font-weight: 700;
            color: #0f172a;
        }

        /* ========== DROPDOWN (NOTIF & PROFILE) ========== */
        .dropdown-menu {
            border-radius: 14px !important;
            border: none;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            z-index: 2000 !important; /* memastikan dropdown di atas card dan grafik */
        }

        .dropdown-item:hover {
            background: var(--gradient);
            color: #fff;
        }

        /* ========== SCROLLBAR ========== */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--teal);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--green);
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 992px) {
            .sidebar {
                position: fixed;
                z-index: 1500;
                height: 100%;
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }
        }

        /* ========== FIX: Dropdown Tertimpa Card/Grafik ========== */
        .stat-card,
        .glass-card,
        .card {
            position: relative;
            z-index: 1;
        }
    </style>
</head>

<body>
    {{-- Sidebar --}}
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">⚙️ Admin</div>

        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-bar-chart"></i><span>Dashboard</span>
        </a>

        <a href="{{ route('admin.content.index') }}" class="{{ request()->routeIs('admin.content.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-text"></i><span>Blog</span>
        </a>

        <a href="{{ route('admin.kegiatan.index') }}" class="{{ request()->routeIs('admin.kegiatan.*') ? 'active' : '' }}">
            <i class="bi bi-calendar-event"></i><span>Kegiatan</span>
        </a>

        <a href="{{ route('admin.team.index') }}" class="{{ request()->routeIs('admin.team.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i><span>Team</span>
        </a>

        <div class="sidebar-footer">
            © 2025 Admin Panel
        </div>
    </div>

    {{-- Main Content --}}
    <div class="content">
        {{-- Navbar --}}
        <div class="navbar-custom">
            <h5 class="mb-0">Admin Panel</h5>

            <div class="d-flex align-items-center gap-3">

                {{-- Notifikasi --}}
                <div class="dropdown">
                    <button class="btn btn-light position-relative rounded-circle shadow-sm p-2"
                        data-bs-toggle="dropdown" title="Notifikasi">
                        <i class="bi bi-bell fs-5"></i>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end"
                        style="width: 300px; max-height: 350px; overflow-y: auto;">
                        <li class="dropdown-header fw-bold">🔔 Notifikasi</li>
                        @forelse($notifications ?? [] as $notif)
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

                {{-- Profile --}}
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                        data-bs-toggle="dropdown">
                        @if(Auth::user()->photo)
                            <img src="{{ asset('storage/' . Auth::user()->photo) }}" class="rounded-circle me-2"
                                width="40" height="40">
                        @else
                            <img src="https://i.pravatar.cc/40?u={{ Auth::user()->email }}" class="rounded-circle me-2"
                                width="40" height="40">
                        @endif
                        <span class="fw-semibold d-none d-md-inline">{{ Auth::user()->name }}</span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('admin.profile.index') }}">
                            <i class="bi bi-person me-2"></i> Profil</a></li>
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

        {{-- Konten Halaman --}}
        @yield('content')
    </div>

    <!-- Sidebar Toggle Script -->
    <script>
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("show");
        }
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
