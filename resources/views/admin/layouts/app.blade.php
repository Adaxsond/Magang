<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    {{-- Link Font Awesome untuk Ikon --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    {{-- Link Bootstrap JS (Penting untuk Tab di Pengaturan Form) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        /* General */
        body {
            margin: 0;
            font-family: 'Segoe UI', 'Helvetica Neue', Arial, sans-serif;
            background-color: #f4f7f9;
            color: #333;
        }
        a { text-decoration: none; color: inherit; }
        ul { list-style-type: none; margin: 0; padding: 0; }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: #ffffff;
            color: #333;
            position: fixed;
            height: 100%;
            display: flex;
            flex-direction: column;
            border-right: 1px solid #e5e7eb;
        }
        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid #e5e7eb;
        }
        .sidebar-logo {
            max-width: 100px;
            margin-bottom: 20px;
        }
        .user-profile {
            background-color: #3b5998;
            color: white;
            padding: 15px;
            margin: 15px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .user-profile .avatar {
            font-size: 24px;
            background-color: rgba(255,255,255,0.2);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .user-profile .user-details {
            flex-grow: 1;
        }
        .user-profile .user-name {
            font-weight: 600;
            display: block;
        }
        .user-profile .user-role {
            font-size: 0.85em;
            opacity: 0.8;
            display: block;
        }
        .period-info {
            background-color: #e0f2f1;
            color: #00796b;
            padding: 8px 15px;
            margin: 0 15px 15px 15px;
            border-radius: 20px;
            text-align: center;
            font-weight: 500;
            font-size: 0.9em;
        }

        .sidebar-nav {
            flex-grow: 1;
            padding: 0 15px;
            overflow-y: auto;
        }
        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 5px;
            color: #4b5563;
            font-weight: 500;
            transition: all 0.2s;
            position: relative;
        }
        .sidebar-nav a i {
            width: 20px;
            text-align: center;
            font-size: 1.1em;
            color: #9ca3af;
            transition: color 0.2s;
        }
        .sidebar-nav a:hover {
            background-color: #f3f4f6;
            color: #1f2937;
        }
        .sidebar-nav a:hover i {
            color: #3b5998;
        }
        .sidebar-nav a.active {
            background-color: #3b5998;
            color: #fff;
            box-shadow: 0 4px 10px rgba(59, 89, 152, 0.3);
        }
        .sidebar-nav a.active i {
            color: #fff;
        }
        .sidebar-nav a.active::after {
            content: '';
            position: absolute;
            right: -15px;
            top: 0;
            height: 100%;
            width: 4px;
            background-color: #3b5998;
            border-radius: 4px 0 0 4px;
        }
        .nav-item-header {
            padding: 10px 15px;
            font-size: 0.75rem;
            font-weight: 700;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 15px;
        }

        /* Main Content */
        .main-content { margin-left: 260px; }
        .header { background: #fff; padding: 15px 30px; box-shadow: 0 1px 4px rgba(0,0,0,0.05); display: flex; justify-content: flex-end; align-items: center; }
        .content-body { padding: 30px; }
    </style>
    @stack('styles')
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <img src="{{ asset('images/logo.jpg') }}" alt="Logo Universitas" class="sidebar-logo">
        </div>
        <div class="user-profile">
            <div class="avatar"><i class="fas fa-user"></i></div>
            <div class="user-details">
                <span class="user-name">{{ Auth::guard('admin')->user()->name }}</span>
                <span class="user-role">{{ Auth::guard('admin')->user()->role == 'superadmin' ? 'Superadmin' : 'Admin' }}</span>
            </div>
            <i class="fas fa-chevron-down"></i>
        </div>
    

        <nav class="sidebar-nav">
            <ul>
                <li class="nav-item-header">MENU UTAMA</li>
                <li><a href="{{ route('admin.dashboard') }}" class="{{ Request::is('admin/dashboard*') ? 'active' : '' }}"><i class="fas fa-home"></i> <span>Dashboard</span></a></li>
                <li><a href="{{ route('admin.dosen.index') }}" class="{{ Request::is('admin/dosen*') ? 'active' : '' }}"><i class="fas fa-users"></i> <span>Data Dosen</span></a></li>
                
                @can('manage-admins')
                    <li class="nav-item-header">ADMINISTRATOR</li>
                    <li><a href="{{ route('admin.admins.index') }}" class="{{ Request::is('admin/admins*') ? 'active' : '' }}"><i class="fas fa-user-shield"></i> <span>Kelola Admin</span></a></li>
                    
                    {{-- DUA LINK BARU --}}
                    <li><a href="{{ route('admin.program-studi.index') }}" class="{{ Request::is('admin/program-studi*') ? 'active' : '' }}"><i class="fas fa-graduation-cap"></i> <span>Program Studi</span></a></li>
                    <li><a href="{{ route('admin.jenis-pkm.index') }}" class="{{ Request::is('admin/jenis-pkm*') ? 'active' : '' }}"><i class="fas fa-lightbulb"></i> <span>Jenis PKM</span></a></li>

                    <li><a href="{{ route('admin.trash.index') }}" class="{{ Request::is('admin/trash*') ? 'active' : '' }}"><i class="fas fa-trash-alt"></i> <span>Tempat Sampah</span></a></li>
                    <li><a href="{{ route('admin.laporan.index') }}" class="{{ Request::is('admin/laporan*') ? 'active' : '' }}"><i class="fas fa-chart-pie"></i> <span>Laporan</span></a></li>
                @endcan
            </ul>
        </nav>
    </div>

    <div class="main-content">
        <header class="header">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger" style="background: #e74c3c; border-radius: 8px; font-weight:500;">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </header>
        <main class="content-body">
            @yield('content')
        </main>
    </div>

    
    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
</body>
</html>