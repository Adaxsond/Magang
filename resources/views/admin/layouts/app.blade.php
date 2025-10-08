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
        /* === GENERAL === */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
            color: #1e293b;
            min-height: 100vh;
        }

        a { 
            text-decoration: none; 
            color: inherit; 
        }

        ul { 
            list-style-type: none; 
        }

        /* === SIDEBAR === */
        .sidebar {
            width: 280px;
            background: #ffffff;
            position: fixed;
            height: 100vh;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 20px rgba(0,0,0,0.08);
            z-index: 1000;
        }

        .sidebar-header {
            padding: 2rem 1.5rem 1.5rem;
            text-align: center;
            border-bottom: 1px solid #e5e7eb;
            background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
        }

        .sidebar-logo {
            max-width: 120px;
            height: auto;
            margin-bottom: 0.5rem;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
        }

        /* === USER PROFILE === */
        .user-profile {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            padding: 1.25rem;
            margin: 1.25rem;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 4px 12px rgba(37,99,235,0.25);
            transition: all 0.3s ease;
        }

        .user-profile:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(37,99,235,0.35);
        }

        .user-profile .avatar {
            font-size: 1.5rem;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .user-profile .user-details {
            flex-grow: 1;
            min-width: 0;
        }

        .user-profile .user-name {
            font-weight: 700;
            font-size: 1rem;
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            letter-spacing: -0.01em;
        }

        .user-profile .user-role {
            font-size: 0.875rem;
            opacity: 0.9;
            display: block;
            margin-top: 0.25rem;
            font-weight: 500;
        }

        .user-profile i.fa-chevron-down {
            font-size: 0.875rem;
            opacity: 0.8;
        }

        /* === NAVIGATION === */
        .sidebar-nav {
            flex-grow: 1;
            padding: 0 1rem 1rem;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-nav::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 3px;
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        .sidebar-nav::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .nav-item-header {
            padding: 1rem 1rem 0.5rem;
            font-size: 0.75rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-top: 0.5rem;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.875rem 1rem;
            border-radius: 0.75rem;
            margin-bottom: 0.375rem;
            color: #475569;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
        }

        .sidebar-nav a::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 0;
            background: linear-gradient(90deg, rgba(37,99,235,0.1) 0%, rgba(37,99,235,0.05) 100%);
            transition: width 0.3s ease;
        }

        .sidebar-nav a:hover::before {
            width: 100%;
        }

        .sidebar-nav a i {
            width: 24px;
            text-align: center;
            font-size: 1.125rem;
            color: #64748b;
            transition: all 0.2s ease;
            position: relative;
            z-index: 1;
        }

        .sidebar-nav a span {
            position: relative;
            z-index: 1;
        }

        .sidebar-nav a:hover {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            color: #1e293b;
            transform: translateX(4px);
        }

        .sidebar-nav a:hover i {
            color: #2563eb;
            transform: scale(1.1);
        }

        .sidebar-nav a.active {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: #fff;
            box-shadow: 0 4px 12px rgba(37,99,235,0.3);
            transform: translateX(4px);
        }

        .sidebar-nav a.active i {
            color: #fff;
            transform: scale(1.1);
        }

        .sidebar-nav a.active::after {
            content: '';
            position: absolute;
            right: -1rem;
            top: 50%;
            transform: translateY(-50%);
            height: 60%;
            width: 4px;
            background: #2563eb;
            border-radius: 4px 0 0 4px;
            box-shadow: -2px 0 8px rgba(37,99,235,0.4);
        }

        /* === MAIN CONTENT === */
        .main-content { 
            margin-left: 280px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* === HEADER === */
        .header { 
            background: #ffffff; 
            padding: 1.25rem 2rem; 
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            display: flex; 
            justify-content: flex-end; 
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .btn-logout {
            background: linear-gradient(135deg, #fecaca 0%, #fca5a5 100%);
            color: #991b1b;
            border: none;
            padding: 0.65rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 2px 8px rgba(239,68,68,0.2);
        }

        .btn-logout:hover {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239,68,68,0.3);
        }

        .btn-logout i {
            font-size: 1rem;
        }

        /* === CONTENT BODY === */
        .content-body { 
            padding: 2rem;
            flex-grow: 1;
        }

        /* === RESPONSIVE === */
        @media (max-width: 768px) {
            .sidebar {
                width: 240px;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .content-body {
                padding: 1.5rem;
            }

            .header {
                padding: 1rem 1.5rem;
            }

            .user-profile {
                margin: 1rem;
                padding: 1rem;
            }

            .user-profile .avatar {
                width: 40px;
                height: 40px;
                font-size: 1.25rem;
            }

            .nav-item-header {
                font-size: 0.7rem;
            }

            .sidebar-nav a {
                padding: 0.75rem 0.875rem;
                font-size: 0.9rem;
            }
        }

        /* === UTILITY CLASSES === */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.65rem 1.4rem;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.95rem;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-danger {
            background: linear-gradient(135deg, #fecaca 0%, #fca5a5 100%);
            color: #991b1b;
            box-shadow: 0 2px 8px rgba(239,68,68,0.2);
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(239,68,68,0.3);
        }
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
                <button type="submit" class="btn-logout">
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
</body>
</html>