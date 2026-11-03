<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - E-Voting OSIS')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #2563eb;
            --secondary: #1e40af;
            --dark: #0f172a;
            --soft: #f1f5f9;
            --card: #ffffff;
            --text: #1f2937;
            --muted: #94a3b8;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--soft);
            color: var(--text);
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #0f172a, #1e293b);
            box-shadow: 4px 0 20px rgba(0,0,0,0.15);
            position: relative;
        }

        .sidebar h5 {
            letter-spacing: 0.5px;
        }

        .sidebar .nav-link {
            color: rgba(255,255,255,0.75);
            padding: 12px 15px;
            border-radius: 12px;
            margin: 6px 0;
            transition: 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar .nav-link:hover {
            background: rgba(255,255,255,0.08);
            color: #fff;
            transform: translateX(5px);
        }

        .sidebar .nav-link.active {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: #fff;
            box-shadow: 0 5px 15px rgba(37,99,235,0.3);
        }

        /* ===== TOPBAR ===== */
        .topbar {
            background: #fff;
            padding: 15px 20px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        /* ===== CONTENT AREA ===== */
        .content-wrapper {
            padding: 25px;
        }

        /* ===== CARD ===== */
        .card {
            border: none;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.06);
            transition: 0.3s;
        }

        .card:hover {
            transform: translateY(-3px);
        }

        /* ===== STAT CARD ===== */
        .stat-card {
            border-radius: 18px;
            padding: 20px;
            color: white;
            transition: 0.3s;
        }

        .stat-card:hover {
            transform: scale(1.03);
        }

        .stat-card.blue { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
        .stat-card.green { background: linear-gradient(135deg, #10b981, #047857); }
        .stat-card.orange { background: linear-gradient(135deg, #f59e0b, #d97706); }
        .stat-card.red { background: linear-gradient(135deg, #ef4444, #dc2626); }

        /* ===== TABLE ===== */
        .table-custom {
            background: #fff;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.06);
        }

        .table-custom thead {
            background: var(--primary);
            color: #fff;
        }

        /* ===== BADGE ===== */
        .badge-status {
            padding: 6px 12px;
            border-radius: 50px;
            font-size: 12px;
        }

        /* ===== IMAGE ===== */
        .kandidat-img {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #e2e8f0;
        }

        /* ===== MOBILE ===== */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                width: 260px;
                transform: translateX(-100%);
                transition: 0.3s ease;
                z-index: 999;
            }

            .sidebar.show {
                transform: translateX(0);
            }
        }
    </style>

    @yield('styles')
</head>

<body>
    <script>
        window.__PAGE_NAME__ = {!! json_encode(\Illuminate\Support\Facades\Request::route()->getName() ?: 'admin') !!};
        window.__PAGE_PROPS__ = {!! json_encode([
            'pageUrl' => url()->current(),
        ]) !!};
    </script>

    <div id="app">

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-md-3 col-lg-2 sidebar p-3" id="sidebar">

            <div class="text-center mb-4">
                <h5 class="text-white fw-bold">
                    <i class="fas fa-shield-alt me-2"></i>ADMIN PANEL
                </h5>
            </div>

            <nav class="nav flex-column">

                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i> Dashboard
                </a>

                <a href="{{ route('admin.siswa.index') }}" class="nav-link {{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> Data Siswa
                </a>

                <a href="{{ route('admin.kandidat.index') }}" class="nav-link {{ request()->routeIs('admin.kandidat.*') ? 'active' : '' }}">
                    <i class="fas fa-user-tie"></i> Data Kandidat
                </a>

                <a href="{{ route('admin.pengaturan') }}" class="nav-link {{ request()->routeIs('admin.pengaturan') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i> Voting Settings
                </a>

                <a href="{{ route('admin.hasil') }}" class="nav-link {{ request()->routeIs('admin.hasil') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar"></i> Hasil Voting
                </a>

                <hr class="text-white">

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="nav-link btn btn-link text-start text-white">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>

            </nav>
        </div>

        <!-- MAIN -->
        <div class="col-md-9 col-lg-10 p-0">

            <!-- TOPBAR -->
            <div class="topbar d-flex justify-content-between align-items-center">
                <button class="btn btn-primary d-md-none" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>

                <div class="ms-auto">
                    <span class="text-muted">Selamat datang, </span>
                    <strong>{{ Auth::user()->nama ?? 'Admin' }}</strong>
                </div>
            </div>

            <!-- CONTENT -->
            <div class="content-wrapper">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')

            </div>

        </div>
    </div>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.getElementById('sidebarToggle').addEventListener('click', function () {
        document.getElementById('sidebar').classList.toggle('show');
    });
</script>

@yield('scripts')

    </div>
</body>
</html>
