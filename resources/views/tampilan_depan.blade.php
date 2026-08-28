<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Portal Utama - Dashboard PDO BP-2</title>

    <!-- Fonts - Poppins untuk kesan bersih dan modern -->
    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            /* SKEMA WARNA: Modern Nature (Deep Green & Gold) */
            --bg-forest: #0a2e1f; /* Hijau Tua Rimbun Sawit */
            --bg-forest-light: #124d34; /* Hijau yang sedikit lebih terang untuk gradasi */
            --bg-gradient: linear-gradient(135deg, var(--bg-forest) 0%, var(--bg-forest-light) 100%);
            
            --glass-bg: rgba(255, 255, 255, 0.03); /* Sangat transparan */
            --glass-border: rgba(255, 255, 255, 0.08);
            
            --accent-color: #f3e5ab; /* Warna Jerami/Emas Muda (Kernel/Minyak Jernih) */
            --accent-glow: rgba(243, 229, 171, 0.3);
            
            --text-main: #ffffff;
            --text-muted: #a0b0a8; /* Abu-abu kehijauan pudar */
            --navbar-bg: rgba(5, 20, 15, 0.9); /* Gelap kehijauan untuk navbar */
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-forest);
            background-image: var(--bg-gradient);
            background-attachment: fixed;
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            position: relative;
        }

        /* AKSEN VISUAL: Siluet Pelepah Sawit Artistik Besar di Sudut */
        body::before {
            content: '';
            position: fixed;
            bottom: -10%;
            left: -10%;
            width: 60vh;
            height: 60vh;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Cpath d='M10,90 Q30,50 90,10 M15,85 Q35,45 85,15 M20,80 Q40,40 80,20 M25,75 Q45,35 75,25 M30,70 Q50,30 70,30 M35,65 Q55,25 65,35' stroke='%23f3e5ab' stroke-opacity='0.04' stroke-width='1' fill='none'/%3E%3C/svg%3E");
            background-size: contain;
            background-repeat: no-repeat;
            z-index: -1;
            transform: rotate(15deg);
        }
        
        body::after {
            content: '';
            position: fixed;
            top: -10%;
            right: -10%;
            width: 50vh;
            height: 50vh;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Cpath d='M90,10 Q70,50 10,90 M85,15 Q65,55 15,85 M80,20 Q60,60 20,80 M75,25 Q55,65 25,75 M70,30 Q50,70 30,70 M65,35 Q55,75 35,65' stroke='%23f3e5ab' stroke-opacity='0.03' stroke-width='1' fill='none'/%3E%3C/svg%3E");
            background-size: contain;
            background-repeat: no-repeat;
            z-index: -1;
            transform: rotate(-10deg);
        }

        /* Nav Styles */
        .navbar {
            background: var(--navbar-bg) !important;
            backdrop-filter: blur(15px);
            border-bottom: 1px solid var(--glass-border);
        }
        .navbar-brand, .nav-link {
            color: var(--text-main) !important;
        }
        .navbar-brand:hover, .nav-link:hover {
            color: var(--accent-color) !important;
        }
        .dropdown-menu {
            background: rgba(10, 30, 20, 0.98);
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
        }
        .dropdown-item {
            color: var(--text-main);
        }
        .dropdown-item:hover {
            background: rgba(243, 229, 171, 0.08);
            color: var(--accent-color);
        }

        /* Hero Section */
        .hero-section {
            padding: 90px 0 70px 0;
            text-align: center;
        }
        .welcome-text {
            font-weight: 300;
            font-size: 1.4rem;
            color: var(--text-muted);
            letter-spacing: 1px;
            margin-bottom: 5px;
        }
        .app-name {
            font-weight: 700;
            font-size: 3.8rem;
            /* Gradient Teks Perak-Emas Halus */
            background: linear-gradient(to right, #ffffff, var(--accent-color), #ffffff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 15px;
            letter-spacing: -1px;
        }
        .instruction-text {
            color: var(--text-muted);
            max-width: 650px;
            margin: 0 auto;
            font-weight: 300;
            font-size: 1rem;
            line-height: 1.6;
        }
        /* Gaya Teks Kustom */
        .custom-text-area {
            font-weight: 300;
            color: var(--text-muted);
            font-style: italic;
            margin-top: 2rem;
            padding: 15px;
            background: rgba(255, 255, 255, 0.02);
            border-radius: 12px;
            display: inline-block;
            border: 1px solid var(--glass-border);
        }

        /* Grid Menu Styles */
        .menu-grid {
            padding-bottom: 100px;
        }

        /* Glass Card Style */
        .menu-card {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            backdrop-filter: blur(20px);
            border-radius: 28px;
            padding: 50px 40px;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            text-decoration: none;
            transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
            position: relative;
            overflow: hidden;
        }

        /* Glow effect on hover */
        .menu-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: radial-gradient(circle at center, var(--accent-glow) 0%, rgba(243, 229, 171, 0) 75%);
            opacity: 0;
            transition: opacity 0.5s;
        }

        .menu-card:hover {
            transform: translateY(-12px);
            border-color: rgba(243, 229, 171, 0.3);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
        }

        .menu-card:hover::before {
            opacity: 1;
        }

        .icon-box {
            font-size: 3.8rem;
            color: var(--accent-color);
            margin-bottom: 30px;
            transition: transform 0.5s;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 110px;
            height: 110px;
            background: rgba(243, 229, 171, 0.05);
            border-radius: 50%;
            border: 1px solid rgba(243, 229, 171, 0.1);
        }

        .menu-card:hover .icon-box {
            transform: scale(1.05) translateY(-5px);
            background: rgba(243, 229, 171, 0.1);
        }

        .menu-title {
            font-weight: 600;
            font-size: 1.6rem;
            color: #ffffff;
            margin-bottom: 12px;
            letter-spacing: 0.5px;
        }

        .menu-desc {
            color: var(--text-muted);
            font-weight: 300;
            font-size: 0.95rem;
            margin-bottom: 0;
            line-height: 1.7;
        }

        /* Khusus Admin Badge */
        .badge-admin {
            position: absolute;
            top: 25px;
            right: 25px;
            background: rgba(243, 229, 171, 0.1);
            color: var(--accent-color);
            border: 1px solid rgba(243, 229, 171, 0.2);
            padding: 6px 18px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            backdrop-filter: blur(5px);
        }

        footer {
            margin-top: auto;
            padding: 25px 0;
            border-top: 1px solid var(--glass-border);
            background: var(--navbar-bg);
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
                    <i class="bi bi-intersect me-2 text-info"></i>Dashboard PDO BP-2
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
                <h1 class="app-name">Dashboard PDO BP-2</h1>
                <p class="instruction-text">Silakan pilih modul aplikasi di bawah ini untuk memulai aktivitas Anda.</p>
                
                {{-- AREA EDIT TULISAN KUSTOM SECARA MANUAL DI SINI --}}
                <div class="custom-text-area mt-4">
                    <i class="bi bi-info-circle me-2"></i>
                    Portal Eksklusif Manajemen Kinerja Operasional Perkebunan Kelapa Sawit BP-2. Pantau data Anda dengan akurat dan real-time.
                </div>
                {{-- BATAS AREA EDIT TULISAN KUSTOM --}}
                
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
                                <i class="bi bi-bar-chart-line"></i>
                            </div>
                            <h3 class="menu-title">Dashboard Utama</h3>
                            <p class="menu-desc">Analisis visual data operasional, grafik tren, dan ringkasan eksekutif bulanan.</p>
                        </a>
                    </div>

                    <!-- MENU 2: Input Data -->
                    <div class="col-md-6 col-lg-4">
                        <a href="{{ url('/input-data') }}" class="menu-card">
                            <div class="icon-box">
                                <i class="bi bi-file-earmark-arrow-up"></i>
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
                                <i class="bi bi-shield-lock"></i>
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
            &copy; {{ date('Y') }} <strong>Dashboard PDO BP-2</strong>. Premium Executive Portal.
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bundle.min.min.js"></script>
</body>
</html>
