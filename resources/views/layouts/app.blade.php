<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'E-Voting OSIS')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
:root {
            --primary-color: #001f3f;
            --secondary-color: #0a1428;
            --accent-color: #DAA520;
            --highlight-gold: #FFD700;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --dark-color: #0a1428;
            --light-color: #ffffff;
            --shadow-blue: rgba(0, 31, 63, 0.3);
            --shadow-gold: rgba(218, 165, 32, 0.4);
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-color);
            color: #333;
        }
        
        .navbar {
            background: linear-gradient(135deg, var(--primary-color), var(--dark-color));
            box-shadow: 0 4px 20px var(--shadow-blue);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }
        
        .navbar-brand:hover {
            color: var(--highlight-gold) !important;
            text-shadow: 0 0 10px var(--shadow-gold);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: 2px solid var(--accent-color);
            color: var(--light-color);
            font-weight: 600;
            border-radius: 25px;
            padding: 10px 25px;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--accent-color), var(--highlight-gold));
            color: var(--primary-color);
            border-color: var(--highlight-gold);
            box-shadow: 0 8px 25px var(--shadow-gold);
            transform: translateY(-2px);
        }
        
        .card {
            background-color: var(--light-color);
            border: 2px solid transparent;
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 50px var(--shadow-blue);
            border-color: var(--accent-color);
        }
        
        .page-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: var(--light-color);
            padding: 3rem 0;
            margin-bottom: 3rem;
            border-radius: 0 0 40px 40px;
            box-shadow: 0 10px 40px var(--shadow-blue);
        }
        
        .page-header h1, .page-header h2 {
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
        
        .stat-card {
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            color: var(--light-color);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .stat-card.blue { 
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); 
        }
        .stat-card.gold { 
            background: linear-gradient(135deg, var(--accent-color), var(--highlight-gold)); 
            color: var(--primary-color);
        }
        .stat-card.green { 
            background: linear-gradient(135deg, #10b981, #047857); 
        }
        .stat-card.red { 
            background: linear-gradient(135deg, #ef4444, #dc2626); 
        }
        
        .kandidat-card {
            border-radius: 25px;
            overflow: hidden;
            margin-bottom: 2rem;
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }
        
        .kandidat-card .card-img-top {
            height: 220px;
            object-fit: cover;
            position: relative;
        }
        
        .kandidat-number {
            position: absolute;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, var(--accent-color), var(--highlight-gold));
            color: var(--primary-color);
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            font-weight: 800;
            box-shadow: 0 5px 15px var(--shadow-gold);
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
        }
        
        .footer {
            background: linear-gradient(135deg, var(--primary-color), var(--dark-color));
            color: var(--light-color);
            padding: 3rem 0 2rem;
            margin-top: 5rem;
            box-shadow: 0 -4px 20px var(--shadow-blue);
        }
        
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color), var(--dark-color));
            color: var(--light-color);
            padding: 5rem 0;
            border-radius: 0 0 60px 60px;
            box-shadow: 0 10px 50px var(--shadow-blue);
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"><defs><radialGradient id=\"g\" cx=\"50%\" cy=\"50%\"><stop offset=\"0%\" stop-color=\"%23FFD700\" stop-opacity=\"0.1\"/><stop offset=\"100%\" stop-color=\"%23DAA520\" stop-opacity=\"0\"/></radialGradient></defs><rect width=\"100\" height=\"100\" fill=\"url(%23g)\"/></svg>');
            pointer-events: none;
        }
        
        .login-box {
            max-width: 450px;
            margin: 3rem auto;
            padding: 3rem;
            border-radius: 25px;
            box-shadow: 0 20px 60px var(--shadow-blue);
            background: var(--light-color);
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }
        
        .login-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--accent-color), var(--highlight-gold));
        }
        
        .table-custom {
            background: var(--light-color);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }
        
        .table-custom thead {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)) !important;
            color: var(--light-color) !important;
        }
        
        .badge-status {
            padding: 0.6rem 1.2rem;
            border-radius: 25px;
            font-size: 0.9rem;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .badge-sudah { 
            background: linear-gradient(135deg, var(--success-color), #059669); 
            color: var(--light-color); 
        }
        .badge-belum { 
            background: linear-gradient(135deg, var(--danger-color), #dc2626); 
            color: var(--light-color); 
        }
        .badge-aktif { 
            background: linear-gradient(135deg, var(--accent-color), var(--highlight-gold)); 
            color: var(--primary-color); 
        }
        .badge-tidak-aktif { 
            background: linear-gradient(135deg, var(--danger-color), #dc2626); 
            color: var(--light-color); 
        }
        
        /* Gold accent links */
        .nav-link:hover {
            color: var(--highlight-gold) !important;
        }
        
        @media (max-width: 768px) {
            .hero-section { padding: 3rem 0; }
            .kandidat-card .card-img-top { height: 200px; }
            .page-header { padding: 2rem 0; margin-bottom: 2rem; }
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <script>
        window.__PAGE_NAME__ = {!! json_encode(\Illuminate\Support\Facades\Request::route()->getName() ?: 'public') !!};
        window.__PAGE_PROPS__ = {!! json_encode([
            'pageUrl' => url()->current(),
        ]) !!};
    </script>

    <div id="app">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-vote-yea me-2"></i>E-Voting OSIS
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/profil') }}">Profil OSIS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/informasi') }}">Informasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/kandidat') }}">Kandidat</a>
                    </li>
                    @auth
                        @if(Auth::user() instanceof \App\Models\Siswa)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/siswa/dashboard') }}">Dashboard</a>
                            </li>
                        @elseif(Auth::user() instanceof \App\Models\Admin)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/admin/dashboard') }}">Dashboard</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-light btn-sm btn-animate">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle btn btn-outline-light btn-sm ms-2 btn-animate" href="#" role="button" data-bs-toggle="dropdown">
                                Login
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ url('/siswa/login') }}">Login Siswa</a></li>
                                <li><a class="dropdown-item" href="{{ url('/admin/login') }}">Login Admin</a></li>
                            </ul>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container text-center">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="fw-bold mb-3">E-Voting OSIS</h5>
                    <p class="mb-3">Memilih pemimpin masa depan dengan mudah, cepat, dan transparan</p>
                    <p class="mb-0 small">&copy; {{ date('Y') }} OSIS. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    @yield('scripts')
</body>
</html>
