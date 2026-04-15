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
    {{-- Google Fonts: Inter --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary:      #6366f1;
            --primary-dark: #4f46e5;
            --secondary:    #8b5cf6;
            --accent:       #06b6d4;
            --success:      #10b981;
            --warning:      #f59e0b;
            --danger:       #ef4444;
            --dark:         #0f172a;
            --dark-2:       #1e293b;
            --dark-3:       #334155;
            --glass-bg:     rgba(255,255,255,0.07);
            --glass-border: rgba(255,255,255,0.15);
        }

        * { box-sizing: border-box; }

        /* ── Base ──────────────────────────────────────── */
        body {
            font-family: 'Inter', sans-serif;
            background: var(--dark);
            color: #e2e8f0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Override Bootstrap dark-theme readability */
        .text-muted           { color: #94a3b8 !important; }
        p                     { color: #cbd5e1; }
        small, .small         { color: #94a3b8; }
        h1,h2,h3,h4,h5,h6    { color: #f1f5f9; }
        li                    { color: #cbd5e1; }
        td, th                { color: #e2e8f0; }
        strong                { color: #f1f5f9; }
        .fw-medium            { color: #e2e8f0; }

        /* ── Navbar ──────────────────────────────────── */
        .navbar-qlc {
            background: rgba(15,23,42,0.95);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--glass-border);
            padding: 1rem 0;
        }
        .navbar-brand {
            font-weight: 800;
            font-size: 1.3rem;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .nav-link { color: #cbd5e1 !important; font-weight: 500; transition: color .2s; }
        .nav-link:hover, .nav-link.active { color: #fff !important; }
        .btn-nav-cta {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: #fff !important;
            border-radius: 8px;
            padding: .45rem 1.2rem;
            font-weight: 600;
            border: none;
            transition: opacity .2s, transform .15s;
        }
        .btn-nav-cta:hover { opacity:.9; transform:translateY(-1px); }

        /* ── Cards ────────────────────────────────────── */
        .card-glass {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            color: #e2e8f0;
        }
        .card-glass .card-header {
            background: rgba(255,255,255,0.05);
            border-bottom: 1px solid var(--glass-border);
            border-radius: 16px 16px 0 0;
            color: #f1f5f9;
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
        }
        .btn-primary-qlc:hover {
            opacity: .92;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(99,102,241,0.4);
            color: #fff;
        }
        .btn-outline-qlc {
            border: 1.5px solid var(--primary);
            color: #a5b4fc;
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
        }
        /* Fix Bootstrap outline-secondary di dark mode */
        .btn-outline-secondary {
            border-color: rgba(255,255,255,0.25) !important;
            color: #cbd5e1 !important;
        }
        .btn-outline-secondary:hover {
            background: rgba(255,255,255,0.1) !important;
            color: #fff !important;
            border-color: rgba(255,255,255,0.35) !important;
        }
        .btn-outline-danger {
            border-color: rgba(239,68,68,0.5) !important;
            color: #fca5a5 !important;
        }
        .btn-outline-danger:hover {
            background: rgba(239,68,68,0.15) !important;
            color: #fca5a5 !important;
        }

        /* ── Form Controls ────────────────────────────── */
        .form-control, .form-select {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.15);
            color: #e2e8f0;
            border-radius: 10px;
        }
        .form-control:focus, .form-select:focus {
            background: rgba(255,255,255,0.12);
            border-color: var(--primary);
            color: #e2e8f0;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.2);
        }
        .form-control::placeholder { color: #64748b; }
        .form-select option         { background: #1e293b; color: #e2e8f0; }
        .form-label                 { font-weight: 500; color: #cbd5e1 !important; margin-bottom: .4rem; }
        .form-check-label           { color: #cbd5e1 !important; }
        .form-text                  { color: #94a3b8 !important; }

        /* ── Alerts ───────────────────────────────────── */
        .alert {
            border-radius: 12px;
            border: 1px solid transparent;
        }
        .alert-success { background: rgba(16,185,129,0.12);  color: #a7f3d0; border-color: rgba(16,185,129,0.25); }
        .alert-danger  { background: rgba(239,68,68,0.12);   color: #fca5a5; border-color: rgba(239,68,68,0.25); }
        .alert-warning { background: rgba(245,158,11,0.12);  color: #fde68a; border-color: rgba(245,158,11,0.25); }
        .alert-info    { background: rgba(6,182,212,0.12);   color: #a5f3fc; border-color: rgba(6,182,212,0.25); }
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
            border: 1.5px solid rgba(255,255,255,0.15);
            border-radius: 12px;
            cursor: pointer;
            transition: all .2s;
            background: rgba(255,255,255,0.05);
            text-align: center;
            font-size: .8rem;
            color: #cbd5e1;
        }
        .likert-label .likert-num {
            font-size: 1.3rem;
            font-weight: 700;
            color: #94a3b8;
        }
        .likert-option:checked + .likert-label {
            border-color: var(--primary);
            background: rgba(99,102,241,0.18);
            color: #c7d2fe;
        }
        .likert-option:checked + .likert-label .likert-num { color: #a5b4fc; }

        /* ── Level Badges ─────────────────────────────── */
        .level-badge-none     { background: rgba(16,185,129,0.18); color: #6ee7b7; }
        .level-badge-mild     { background: rgba(6,182,212,0.18);  color: #67e8f9; }
        .level-badge-moderate { background: rgba(245,158,11,0.18); color: #fcd34d; }
        .level-badge-severe   { background: rgba(239,68,68,0.18);  color: #fca5a5; }

        /* ── Footer ───────────────────────────────────── */
        .footer-qlc {
            background: var(--dark-2);
            border-top: 1px solid var(--glass-border);
            padding: 1.5rem 0;
            margin-top: auto;
        }
        .footer-qlc p,
        .footer-qlc small,
        .footer-qlc span { color: #94a3b8; }

        /* ── Table ────────────────────────────────────── */
        .table-dark-qlc {
            --bs-table-bg: transparent;
            --bs-table-striped-bg: rgba(255,255,255,0.03);
            --bs-table-border-color: rgba(255,255,255,0.08);
            color: #e2e8f0;
        }

        /* ── Dropdown ─────────────────────────────────── */
        .dropdown-menu       { background: var(--dark-2) !important; border: 1px solid var(--glass-border) !important; }
        .dropdown-item       { color: #cbd5e1 !important; }
        .dropdown-item:hover { background: rgba(255,255,255,0.08) !important; color: #fff !important; }
        .dropdown-item.text-danger { color: #fca5a5 !important; }
        .dropdown-divider    { border-color: rgba(255,255,255,0.1) !important; }

        /* ── Pagination ───────────────────────────────── */
        .pagination .page-link          { background: rgba(255,255,255,0.06); border-color: rgba(255,255,255,0.12); color: #94a3b8; }
        .pagination .page-link:hover    { background: rgba(99,102,241,0.2); color: #a5b4fc; border-color: rgba(99,102,241,0.3); }
        .pagination .page-item.active .page-link   { background: var(--primary); border-color: var(--primary); color: #fff; }
        .pagination .page-item.disabled .page-link { background: rgba(255,255,255,0.03); color: #475569; }

        /* ── Scrollbar ────────────────────────────────── */
        ::-webkit-scrollbar       { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--dark-2); }
        ::-webkit-scrollbar-thumb { background: var(--dark-3); border-radius: 3px; }

        /* ── Animations ───────────────────────────────── */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeup { animation: fadeInUp .5s ease forwards; }

        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(99,102,241,0); }
            50%       { box-shadow: 0 0 20px 4px rgba(99,102,241,0.3); }
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
            <i class="bi bi-brain me-2"></i>QLC Detector
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
                style="border-color:rgba(255,255,255,0.2);">
            <span class="navbar-toggler-icon" style="filter:invert(1) opacity(.8);"></span>
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
            <button type="button" class="btn-close" style="filter:invert(1)" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" style="filter:invert(1)" data-bs-dismiss="alert"></button>
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
