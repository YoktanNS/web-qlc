<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Pendukung Keputusan untuk deteksi dan penanganan Quarter-Life Crisis menggunakan metode Forward Chaining dan SAW">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'QLC Detector') — Sistem Deteksi QLC</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    {{-- Google Fonts: Plus Jakarta Sans (premium) --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            /* ── Cream + Sage Green Light Theme ── */
            --primary:       #6b9e72;   /* sage green */
            --primary-dark:  #4a7a52;   /* deeper sage */
            --primary-light: #e6f0e8;   /* soft sage tint */
            --secondary:     #8cb87a;   /* mellow olive */
            --accent:        #b5906a;   /* warm caramel */
            --cream:         #f8f4ed;   /* ivory main bg */
            --cream-2:       #f0ead9;   /* deeper cream sections */
            --cream-3:       #e8dece;   /* footer / dividers */
            --card-bg:       #ffffff;   /* card surface */
            --card-border:   #ddd5c4;   /* warm taupe border */
            --text-main:     #2e2a22;   /* warm near-black */
            --text-sub:      #5c5648;   /* warm brown-gray */
            --text-muted:    #9a9082;   /* muted taupe */
            --success:       #4e8f55;
            --warning:       #a87a28;
            --danger:        #a83a3a;
        }

        * { box-sizing: border-box; }

        /* ── Base ──────────────────────────────────────── */
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--cream);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── Override Bootstrap typography ──────────────── */
        .text-muted           { color: var(--text-muted) !important; }
        p                     { color: var(--text-sub); }
        small, .small         { color: var(--text-muted); }
        h1,h2,h3,h4,h5,h6    { color: var(--text-main); }
        li                    { color: var(--text-sub); }
        td, th                { color: var(--text-main); }
        strong                { color: var(--text-main); }
        .fw-medium            { color: var(--text-sub); }
        .text-light           { color: var(--text-main) !important; }

        /* ── Navbar ──────────────────────────────────── */
        .navbar-qlc {
            background: rgba(255, 253, 248, 0.95);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--card-border);
            padding: 1rem 0;
            box-shadow: 0 2px 20px rgba(107,158,114,0.09);
        }
        .navbar-brand {
            font-weight: 800;
            font-size: 1.3rem;
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .nav-link { color: var(--text-sub) !important; font-weight: 500; transition: color .2s; }
        .nav-link:hover, .nav-link.active { color: var(--primary-dark) !important; }
        .btn-nav-cta {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: #fff !important;
            border-radius: 8px;
            padding: .45rem 1.2rem;
            font-weight: 600;
            border: none;
            transition: opacity .2s, transform .15s, box-shadow .2s;
            box-shadow: 0 2px 12px rgba(107,158,114,0.28);
        }
        .btn-nav-cta:hover { opacity:.9; transform:translateY(-1px); box-shadow: 0 4px 18px rgba(107,158,114,0.4); }

        /* ── Cards ────────────────────────────────────── */
        .card-glass {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 16px;
            color: var(--text-main);
            box-shadow: 0 4px 28px rgba(90,80,60,0.07), 0 1px 4px rgba(0,0,0,0.04);
        }
        .card-glass .card-header {
            background: var(--primary-light);
            border-bottom: 1px solid var(--card-border);
            border-radius: 16px 16px 0 0;
            color: var(--primary-dark);
        }

        /* ── Buttons ──────────────────────────────────── */
        .btn-primary-qlc {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            color: #fff;
            font-weight: 600;
            border-radius: 10px;
            padding: .65rem 1.5rem;
            transition: opacity .2s, transform .15s, box-shadow .2s;
            box-shadow: 0 2px 14px rgba(107,158,114,0.28);
        }
        .btn-primary-qlc:hover {
            opacity: .92;
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(107,158,114,0.42);
            color: #fff;
        }
        .btn-outline-qlc {
            border: 1.5px solid var(--primary);
            color: var(--primary-dark);
            border-radius: 10px;
            font-weight: 600;
            padding: .65rem 1.5rem;
            background: transparent;
            transition: all .2s;
        }
        .btn-outline-qlc:hover {
            background: var(--primary);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(107,158,114,0.3);
        }
        .btn-outline-secondary {
            border-color: var(--card-border) !important;
            color: var(--text-sub) !important;
            background: transparent;
        }
        .btn-outline-secondary:hover {
            background: var(--cream-2) !important;
            color: var(--text-main) !important;
            border-color: var(--accent) !important;
        }
        .btn-outline-danger {
            border-color: rgba(168,58,58,0.4) !important;
            color: var(--danger) !important;
        }
        .btn-outline-danger:hover {
            background: rgba(168,58,58,0.08) !important;
            color: var(--danger) !important;
        }

        /* ── Form Controls ────────────────────────────── */
        .form-control, .form-select {
            background: #fff;
            border: 1px solid var(--card-border);
            color: var(--text-main);
            border-radius: 10px;
        }
        .form-control:focus, .form-select:focus {
            background: #fff;
            border-color: var(--primary);
            color: var(--text-main);
            box-shadow: 0 0 0 3px rgba(107,158,114,0.16);
        }
        .form-control::placeholder { color: var(--text-muted); }
        .form-select option         { background: #fff; color: var(--text-main); }
        .form-label                 { font-weight: 500; color: var(--text-sub) !important; margin-bottom: .4rem; }
        .form-check-label           { color: var(--text-sub) !important; }
        .form-text                  { color: var(--text-muted) !important; }

        /* ── Alerts ───────────────────────────────────── */
        .alert {
            border-radius: 12px;
            border: 1px solid transparent;
        }
        .alert-success { background: rgba(78,143,85,0.10);  color: #3a6e40; border-color: rgba(78,143,85,0.22); }
        .alert-danger  { background: rgba(168,58,58,0.09);  color: #8b3030; border-color: rgba(168,58,58,0.22); }
        .alert-warning { background: rgba(168,122,40,0.10); color: #7a5818; border-color: rgba(168,122,40,0.22); }
        .alert-info    { background: rgba(107,158,114,0.10); color: #3a6e43; border-color: rgba(107,158,114,0.22); }
        .alert a, .alert strong { color: inherit; }
        .alert a  { font-weight: 600; text-decoration: underline; }

        /* ── Likert Scale ─────────────────────────────── */
        .likert-option { display: none; }
        .likert-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: .4rem;
            padding: .75rem .5rem;
            border: 1.5px solid var(--card-border);
            border-radius: 12px;
            cursor: pointer;
            transition: all .2s;
            background: var(--cream);
            text-align: center;
            font-size: .8rem;
            color: var(--text-sub);
        }
        .likert-label .likert-num {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--text-muted);
        }
        .likert-option:checked + .likert-label {
            border-color: var(--primary);
            background: var(--primary-light);
            color: var(--primary-dark);
            box-shadow: 0 0 0 3px rgba(107,158,114,0.14);
        }
        .likert-option:checked + .likert-label .likert-num { color: var(--primary-dark); font-weight: 800; }

        /* ── Level Badges ─────────────────────────────── */
        .level-badge-none     { background: rgba(78,143,85,0.12);  color: #3a6e40; border: 1px solid rgba(78,143,85,0.2); }
        .level-badge-mild     { background: rgba(181,144,106,0.14); color: #6e4e28; border: 1px solid rgba(181,144,106,0.25); }
        .level-badge-moderate { background: rgba(168,122,40,0.12); color: #7a5818; border: 1px solid rgba(168,122,40,0.25); }
        .level-badge-severe   { background: rgba(168,58,58,0.10);  color: #8b3030; border: 1px solid rgba(168,58,58,0.2); }

        /* ── Footer ───────────────────────────────────── */
        .footer-qlc {
            background: var(--cream-3);
            border-top: 1px solid var(--card-border);
            padding: 1.5rem 0;
            margin-top: auto;
        }
        .footer-qlc p,
        .footer-qlc small,
        .footer-qlc span { color: var(--text-muted); }

        /* ── Table ────────────────────────────────────── */
        .table-dark-qlc {
            --bs-table-bg: transparent;
            --bs-table-striped-bg: rgba(107,158,114,0.05);
            --bs-table-border-color: var(--card-border);
            color: var(--text-main);
        }

        /* ── Dropdown ─────────────────────────────────── */
        .dropdown-menu       { background: #fff !important; border: 1px solid var(--card-border) !important; box-shadow: 0 8px 32px rgba(60,50,30,0.1) !important; }
        .dropdown-item       { color: var(--text-sub) !important; }
        .dropdown-item:hover { background: var(--primary-light) !important; color: var(--primary-dark) !important; }
        .dropdown-item.text-danger { color: var(--danger) !important; }
        .dropdown-divider    { border-color: var(--card-border) !important; }

        /* ── Pagination ───────────────────────────────── */
        .pagination .page-link          { background: #fff; border-color: var(--card-border); color: var(--text-muted); }
        .pagination .page-link:hover    { background: var(--primary-light); color: var(--primary-dark); border-color: var(--primary); }
        .pagination .page-item.active .page-link   { background: var(--primary); border-color: var(--primary); color: #fff; }
        .pagination .page-item.disabled .page-link { background: var(--cream-2); color: var(--text-muted); }

        /* ── Scrollbar ────────────────────────────────── */
        ::-webkit-scrollbar       { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--cream-2); }
        ::-webkit-scrollbar-thumb { background: var(--card-border); border-radius: 3px; }

        /* ── Progress bars ────────────────────────────── */
        .progress { background: var(--cream-2) !important; }

        /* ── Section backgrounds ──────────────────────── */
        section.bg-alt { background: var(--cream-2); }
        .border-top.border-secondary { border-color: var(--card-border) !important; }

        /* ── Animations ───────────────────────────────── */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeup { animation: fadeInUp .5s ease forwards; }

        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(107,158,114,0); }
            50%       { box-shadow: 0 0 22px 6px rgba(107,158,114,0.22); }
        }
        .pulse-glow { animation: pulse-glow 2.5s infinite; }
    </style>

    @stack('styles')
</head>
<body>

{{-- Navbar --}}
<nav class="navbar navbar-expand-lg navbar-qlc sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <i class="bi bi-emoji-dizzy me-2"></i>QLC Detector
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
                style="border-color: var(--card-border);">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('kuesioner*') ? 'active' : '' }}" href="{{ route('assessment.intro') }}">Tes QLC</a>
                </li>
                @auth
                    @if(auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin*') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Panel Admin</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('riwayat*') ? 'active' : '' }}" href="{{ route('result.history') }}">Riwayat</a>
                        </li>
                    @endif
                @endauth
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('sus.form') }}">Form SUS</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center gap-2">
                @guest
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Masuk</a></li>
                    <li class="nav-item"><a class="btn btn-nav-cta" href="{{ route('register') }}">Daftar</a></li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i>Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger" type="submit">
                                        <i class="bi bi-box-arrow-right me-2"></i>Keluar
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

{{-- Flash Messages --}}
<div class="container mt-3">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
</div>

{{-- Main Content --}}
<main class="flex-grow-1">
    @yield('content')
</main>

{{-- Footer --}}
<footer class="footer-qlc">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <span class="fw-bold" style="background: linear-gradient(135deg, var(--primary), var(--accent)); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;">
                    QLC Detector
                </span>
                <span class="ms-2 small">Sistem Pendukung Keputusan Quarter-Life Crisis</span>
            </div>
            <div class="col-md-6 text-md-end small">
                <span>Metode: Forward Chaining + SAW</span>
                <span class="mx-2">·</span>
                <span>Berbasis DCQ-12 (Petrov et al., 2022)</span>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12">
                <small>
                    <i class="bi bi-info-circle me-1"></i>
                    Sistem ini adalah alat bantu penilaian mandiri (self-assessment tool), bukan pengganti diagnosis klinis.
                </small>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
@stack('scripts')
</body>
</html>
