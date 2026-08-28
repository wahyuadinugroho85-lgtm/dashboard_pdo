<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Portal Utama - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts - Menggunakan Poppins agar lebih kekinian -->
    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            --bg-gradient: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            --glass-bg: rgba(255, 255, 255, 0.05);
            --glass-border: rgba(255, 255, 255, 0.1);
            --accent-color: #38bdf8; /* Sky blue yang modern */
            --text-main: #f1f5f9;
            --text-muted: #94a3b8;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg-gradient);
            background-attachment: fixed;
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        /* Nav Styles */
        .navbar {
            background: rgba(15, 23, 42, 0.8) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--glass-border);
        }
        .navbar-brand, .nav-link {
            color: var(--text-main) !important;
        }
        .nav-link:hover {
            color: var(--accent-color) !important;
        }
        .dropdown-menu {
            background: rgba(30, 41, 59, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
        }
        .dropdown-item {
            color: var(--text-main);
        }
        .dropdown-item:hover {
            background: rgba(56, 189, 248, 0.1);
            color: var(--accent-color);
        }

        /* Hero Section */
        .hero-section {
            padding: 80px 0 60px 0;
            text-align: center;
        }
        .welcome-text {
            font-weight: 300;
            font-size: 1.5rem;
            color: var(--text-muted);
            letter-spacing: 1px;
        }
        .app-name {
            font-weight: 700;
            font-size: 3.5rem;
            background: linear-gradient(to right, #ffffff, var(--accent-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 10px;
        }
        .instruction-text {
            color: var(--text-muted);
            max-width: 600px;
            margin: 0 auto;
            font-weight: 300;
        }

        /* Grid Menu Styles */
        .menu-grid {
            padding-bottom: 80px;
        }

        /* Glass Card Style */
        .menu-card {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            padding: 40px;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            text-decoration: none;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
        }

        /* Glow effect on hover */
        .menu-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: radial-gradient(circle at center, rgba(56, 189, 248, 0.15) 0%, rgba(56, 189, 248, 0) 70%);
            opacity: 0;
            transition: opacity 0.4s;
        }

        .menu-card:hover {
            transform: translateY(-10px) scale(1.02);
            border-color: rgba(56, 189, 248, 0.4);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }

        .menu-card:hover::before {
            opacity: 1;
        }

        .icon-box {
            font-size: 3.5rem;
            color: var(--accent-color);
            margin-bottom: 25px;
            transition: transform 0.4s;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100px;
            height: 100px;
            background: rgba(56, 189, 248, 0.1);
            border-radius: 50%;
        }

        .menu-card:hover .icon-box {
            transform: scale(1.1) rotate(5deg);
        }

        .menu-title {
            font-weight: 600;
            font-size: 1.5rem;
            color: #ffffff;
            margin-bottom: 10px;
            letter-spacing: 0.5px;
        }

        .menu-desc {
            color: var(--text-muted);
            font-weight: 300;
            font-size: 0.95rem;
            margin-bottom: 0;
            line-height: 1.6;
        }

        /* Khusus Admin Badge */
        .badge-admin {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(244, 63, 94, 0.2);
            color: #fb7185;
            border: 1px solid rgba(244, 63, 94, 0.3);
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        footer {
            margin-top: auto;
            padding: 20px 0;
            border-top: 1px solid var(--glass-border);
            background: rgba(15, 23, 42, 0.6);
            text-align: center;
            color: var(--text-muted);
            font-size: 0.9rem;
            font-weight: 300;
        }
    </style>
</head>
<body>
    <div id="app">
        <!-- Navbar Minimalis Mewah -->
        <nav class="navbar navbar-expand-md navbar-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                    <i class="bi bi-layers-half me-2 text-info"></i>{{ config('app.name', 'Laravel') }}
                </a>
                
                <div class="ms-auto">
                    <ul class="navbar-nav">
                        @guest
                            <!-- Guest view jika diperlukan -->
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle fw-semibold" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="navbarDropdown">
                                    <div class="dropdown-header text-muted font-monospace text-uppercase" style="font-size: 0.7rem;">Role: {{ Auth::user()->role }}</div>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right me-2"></i>{{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <header class="hero-sectioncontainer">
            <div class="container">
                <p class="welcome-text">Selamat Datang,</p>
                <h1 class="app-name">{{ config('app.name', 'Digital Dashboard') }}</h1>
                <p class="instruction-text">Silakan pilih modul aplikasi di bawah ini untuk memulai aktivitas Anda.</p>
            </div>
        </header>

        <!-- Main Menu Grid -->
        <main class="menu-grid">
            <div class="container">
                <div class="row g-4 justify-content-center">
                    
                    <!-- MENU 1: Laporan Manajemen -->
                    <div class="col-md-6 col-lg-4">
                        <a href="{{ url('/laporan-manajemen') }}" class="menu-card">
                            <div class="icon-box">
                                <i class="bi bi-speedometer2"></i>
                            </div>
                            <h3 class="menu-title">Dashboard Utama</h3>
                            <p class="menu-desc">Analisis visual data operasional, grafik tren, dan ringkasan eksekutif bulanan.</p>
                        </a>
                    </div>

                    <!-- MENU 2: Input Data -->
                    <div class="col-md-6 col-lg-4">
                        <a href="{{ url('/input-data') }}" class="menu-card">
                            <div class="icon-box">
                                <i class="bi bi-pencil-square"></i>
                            </div>
                            <h3 class="menu-title">Input & Import</h3>
                            <p class="menu-desc">Formulir input data manual, fitur import Excel, dan unduh template data.</p>
                        </a>
                    </div>

                    {{-- Menampilkan Menu Kelola User HANYA untuk Admin --}}
                    @if(Auth::check() && Auth::user()->role === 'admin')
                    <!-- MENU 3: Kelola User (Khusus Admin) -->
                    <div class="col-md-6 col-lg-4">
                        <a href="{{ route('kelola.user') }}" class="menu-card">
                            <span class="badge-admin">Admin</span>
                            <div class="icon-box">
                                <i class="bi bi-people"></i>
                            </div>
                            <h3 class="menu-title">Manajemen User</h3>
                            <p class="menu-desc">Pengaturan hak akses pengguna, tambah user baru, edit data, dan reset password.</p>
                        </a>
                    </div>
                    @endif

                </div>
            </div>
        </main>
    </div>

    <footer>
        <div class="container">
            &copy; {{ date('Y') }} <strong>{{ config('app.name') }}</strong>. Premium Executive Portal.
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bundle.min.min.js"></script>
</body>
</html>
