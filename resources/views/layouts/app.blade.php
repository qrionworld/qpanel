<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            display: flex;
            min-height: 100vh;
            transition: background-color 0.3s, color 0.3s;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: white;
            flex-shrink: 0;
            transition: width 0.3s ease;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        .sidebar.collapsed {
            width: 70px;
        }

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
        }
        .sidebar.collapsed .sidebar-header h4 {
            display: none;
        }

        .collapse-btn {
            background: none;
            border: none;
            color: white;
            font-size: 1.3rem;
            cursor: pointer;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            transition: background-color 0.2s;
            white-space: nowrap;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .sidebar i {
            font-size: 1.2rem;
            margin-right: 10px;
            min-width: 25px;
            text-align: center;
        }
        .sidebar.collapsed a span {
            display: none;
        }

        /* Content */
        .content {
            flex-grow: 1;
            padding: 20px;
            background-color: #f8f9fa;
            transition: margin-left 0.3s ease;
        }

        /* Dark mode */
        body.dark-mode {
            background-color: #1e1e1e;
            color: #eaeaea;
        }
        body.dark-mode .content {
            background-color: #2c2c2c;
            color: white;
        }
        body.dark-mode .sidebar {
            background-color: #1f1f1f;
        }
        body.dark-mode .sidebar a {
            color: white;
        }

        /* Navbar in content */
        .navbar-custom {
            padding: 10px 20px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
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

    {{-- Dashboard --}}
    <a href="{{ route('admin.dashboard') }}">
        <i class="bi bi-bar-chart"></i><span>Dashboard</span>
    </a>

    {{-- Content --}}
    <a href="{{ route('admin.content.index') }}">
    <i class="bi bi-file-earmark-text"></i><span>Content</span>
</a>


    {{-- Categories --}}
    <a href="{{ route('admin.categories.index') }}">
        <i class="bi bi-tags"></i><span>Categories</span>
    </a>

    {{-- Settings --}}
    <a href="{{ route('admin.settings.index') }}">
        <i class="bi bi-gear"></i><span>Settings</span>
    </a>
</div>

    {{-- Main Content --}}
    <div class="content">
        <div class="navbar-custom">
            <button class="btn btn-sm btn-dark" onclick="toggleDarkMode()">🌙 / ☀️</button>
        </div>
        <hr>
        @yield('content')
    </div>

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('collapsed');
        }

        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
        }
    </script>
</body>
</html>
