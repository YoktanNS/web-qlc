<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Panel Admin QLC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            /* ── Cream + Sage Green Luxury Theme ── */
            --primary:       #6b9e72;
            --primary-dark:  #4a7a52;
            --primary-light: #e6f0e8;
            --secondary:     #8cb87a;
            --accent:        #b5906a;
            --cream:         #f8f4ed;
            --cream-2:       #f0ead9;
            --cream-3:       #e8dece;
            --card-bg:       #ffffff;
            --card-border:   #ddd5c4;
            --sidebar-bg:    #ffffff;
            --sidebar-w:     240px;
            --header-h:      60px;
            --text-main:     #2e2a22;
            --text-sub:      #5c5648;
            --text-muted:    #9a9082;
            --success:       #4e8f55;
            --warning:       #a87a28;
            --danger:        #a83a3a;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            background: var(--cream);
            color: var(--text-main);
            margin: 0;
        }

        /* ── Typography ── */
        .text-muted         { color: var(--text-muted) !important; }
        p                   { color: var(--text-sub); }
        small, .small       { color: var(--text-muted); }
        h1,h2,h3,h4,h5,h6  { color: var(--text-main); font-weight: 700; }
        strong              { color: var(--text-main); }
        td, th              { color: var(--text-main); }
        li                  { color: var(--text-sub); }
        label, .form-label  { color: var(--text-sub) !important; font-weight: 600; font-size: .85rem; }
        .form-check-label   { color: var(--text-sub) !important; }

        /* ── Header ── */
        .admin-header {
            background: rgba(255, 253, 248, 0.97);
            border-bottom: 1px solid var(--card-border);
            height: var(--header-h);
            display: flex;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 200;
            backdrop-filter: blur(16px);
            box-shadow: 0 2px 16px rgba(107,158,114,0.08);
        }
        .admin-header .container-fluid { padding: 0 1.25rem; }
        .brand-text {
            font-weight: 800;
            font-size: 1.1rem;
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-decoration: none;
        }
        .header-panel-badge {
            background: rgba(181,144,106,0.15);
            color: var(--accent);
            border: 1px solid rgba(181,144,106,0.3);
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .04em;
            padding: 2px 8px;
            border-radius: 20px;
        }
        .header-user-tag {
            font-size: .83rem;
            font-weight: 600;
            color: var(--text-sub);
        }
        .btn-header-link {
            font-size: .82rem;
            font-weight: 600;
            color: var(--text-muted);
            text-decoration: none;
            transition: color .2s;
        }
        .btn-header-link:hover { color: var(--primary-dark); }
        .btn-logout {
            background: rgba(168,58,58,0.08);
            color: var(--danger);
            border: 1px solid rgba(168,58,58,0.2);
            border-radius: 8px;
            padding: .3rem .85rem;
            font-size: .78rem;
            font-weight: 600;
            transition: all .2s;
        }
        .btn-logout:hover {
            background: rgba(168,58,58,0.15);
            color: var(--danger);
        }

        /* ── Layout ── */
        .admin-wrapper {
            display: flex;
            min-height: calc(100vh - var(--header-h));
        }
        .admin-sidebar {
            width: var(--sidebar-w);
            background: var(--sidebar-bg);
            border-right: 1px solid var(--card-border);
            padding: 1.25rem .875rem;
            flex-shrink: 0;
            position: sticky;
            top: var(--header-h);
            height: calc(100vh - var(--header-h));
            overflow-y: auto;
            box-shadow: 2px 0 12px rgba(90,80,60,0.04);
        }
        .admin-content {
            flex: 1;
            padding: 2rem;
            overflow-x: auto;
            background: var(--cream);
        }

        /* ── Sidebar ── */
        .sidebar-heading {
            font-size: .68rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .1em;
            color: var(--text-muted);
            padding: .5rem .75rem .3rem;
            margin-top: .5rem;
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: .6rem;
            padding: .6rem .75rem;
            border-radius: 10px;
            color: var(--text-sub);
            font-size: .858rem;
            font-weight: 600;
            text-decoration: none;
            margin-bottom: .15rem;
            transition: all .2s;
            border: 1px solid transparent;
        }
        .sidebar-link:hover {
            background: var(--primary-light);
            color: var(--primary-dark);
            border-color: rgba(107,158,114,0.15);
        }
        .sidebar-link.active {
            background: var(--primary-light);
            color: var(--primary-dark);
            border-color: rgba(107,158,114,0.25);
            box-shadow: 0 2px 8px rgba(107,158,114,0.12);
        }
        .sidebar-link.active i { color: var(--primary); }
        .sidebar-link i {
            font-size: 1rem;
            width: 18px;
            text-align: center;
            color: var(--text-muted);
            transition: color .2s;
        }
        .sidebar-link:hover i  { color: var(--primary); }

        /* ── Stat Cards ── */
        .card-stat {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 14px;
            padding: 1.4rem;
            color: var(--text-main);
            box-shadow: 0 2px 18px rgba(90,80,60,0.06);
            transition: transform .2s, box-shadow .2s;
        }
        .card-stat:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(90,80,60,0.10);
        }
        .card-stat .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            flex-shrink: 0;
        }
        .card-stat .small { color: var(--text-muted); }
        .card-stat .stat-value { font-size: 1.75rem; font-weight: 800; color: var(--text-main); line-height: 1; }
        .card-stat .stat-label { font-size: .82rem; color: var(--text-muted); font-weight: 500; }

        /* ── Glass Card (admin content cards) ── */
        .card-glass {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 14px;
            color: var(--text-main);
            box-shadow: 0 2px 18px rgba(90,80,60,0.06);
        }
        .card-glass .card-header {
            background: var(--cream-2);
            border-bottom: 1px solid var(--card-border);
            border-radius: 14px 14px 0 0;
            color: var(--text-main);
            padding: 1rem 1.25rem;
            font-weight: 700;
        }

        /* ── Form Controls ── */
        .form-control, .form-select {
            background: #fff;
            border: 1px solid var(--card-border);
            color: var(--text-main);
            border-radius: 10px;
            font-size: .875rem;
        }
        .form-control:focus, .form-select:focus {
            background: #fff;
            border-color: var(--primary);
            color: var(--text-main);
            box-shadow: 0 0 0 3px rgba(107,158,114,0.15);
        }
        .form-control::placeholder { color: var(--text-muted); }
        .form-select option { background: #fff; color: var(--text-main); }
        .form-range { accent-color: var(--primary); }

        /* ── Buttons ── */
        .btn-primary-admin {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            color: #fff;
            font-weight: 700;
            border-radius: 9px;
            padding: .5rem 1.25rem;
            font-size: .875rem;
            transition: opacity .2s, transform .15s, box-shadow .2s;
            box-shadow: 0 2px 10px rgba(107,158,114,0.28);
        }
        .btn-primary-admin:hover {
            opacity: .92;
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 18px rgba(107,158,114,0.38);
        }
        .btn-outline-secondary {
            border-color: var(--card-border) !important;
            color: var(--text-sub) !important;
            background: transparent;
            font-weight: 600;
        }
        .btn-outline-secondary:hover {
            background: var(--cream-2) !important;
            color: var(--text-main) !important;
            border-color: var(--accent) !important;
        }
        .btn-outline-danger {
            border-color: rgba(168,58,58,0.35) !important;
            color: var(--danger) !important;
            font-weight: 600;
        }
        .btn-outline-danger:hover {
            background: rgba(168,58,58,0.08) !important;
        }
        .btn-outline-primary {
            border-color: rgba(107,158,114,0.5) !important;
            color: var(--primary-dark) !important;
            font-weight: 600;
        }
        .btn-outline-primary:hover {
            background: var(--primary-light) !important;
            color: var(--primary-dark) !important;
        }

        /* ── Table ── */
        .table-qlc {
            --bs-table-bg: transparent;
            --bs-table-border-color: var(--card-border);
            color: var(--text-main);
        }
        .table-qlc thead th {
            background: var(--cream-2);
            color: var(--text-muted);
            font-size: .75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .07em;
            border-bottom: 2px solid var(--card-border);
            padding: .875rem 1rem;
        }
        .table-qlc tbody td {
            padding: .875rem 1rem;
            vertical-align: middle;
            border-color: rgba(221,213,196,0.5);
            font-size: .875rem;
            color: var(--text-main);
        }
        .table-qlc tbody tr:hover { background: rgba(107,158,114,0.04); }

        /* ── Alerts ── */
        .alert          { border-radius: 12px; border: 1px solid transparent; font-size: .875rem; }
        .alert-success  { background: rgba(78,143,85,0.10);  color: #3a6e40; border-color: rgba(78,143,85,0.22); }
        .alert-danger   { background: rgba(168,58,58,0.09);  color: #8b3030; border-color: rgba(168,58,58,0.22); }
        .alert-warning  { background: rgba(168,122,40,0.10); color: #7a5818; border-color: rgba(168,122,40,0.22); }
        .alert-info     { background: rgba(107,158,114,0.10); color: #3a6e43; border-color: rgba(107,158,114,0.22); }
        .alert a, .alert strong { color: inherit; }

        /* ── Level Badges ── */
        .badge-level-none     { background: rgba(78,143,85,0.12);   color: #3a6e40; border: 1px solid rgba(78,143,85,0.2); }
        .badge-level-mild     { background: rgba(181,144,106,0.14); color: #6e4e28; border: 1px solid rgba(181,144,106,0.25); }
        .badge-level-moderate { background: rgba(168,122,40,0.12);  color: #7a5818; border: 1px solid rgba(168,122,40,0.25); }
        .badge-level-severe   { background: rgba(168,58,58,0.10);   color: #8b3030; border: 1px solid rgba(168,58,58,0.2); }

        /* ── Dropdown ── */
        .dropdown-menu       { background: #fff !important; border: 1px solid var(--card-border) !important; box-shadow: 0 8px 30px rgba(60,50,30,0.1) !important; border-radius: 12px !important; }
        .dropdown-item       { color: var(--text-sub) !important; font-size: .875rem; }
        .dropdown-item:hover { background: var(--primary-light) !important; color: var(--primary-dark) !important; }
        .dropdown-item.text-danger  { color: var(--danger) !important; }
        .dropdown-divider    { border-color: var(--card-border) !important; }

        /* ── Pagination ── */
        .pagination .page-link          { background: #fff; border-color: var(--card-border); color: var(--text-muted); font-size: .875rem; }
        .pagination .page-link:hover    { background: var(--primary-light); color: var(--primary-dark); border-color: var(--primary); }
        .pagination .page-item.active .page-link   { background: var(--primary); border-color: var(--primary); color: #fff; }
        .pagination .page-item.disabled .page-link { background: var(--cream-2); color: var(--text-muted); }

        /* ── Progress bar ── */
        .progress { background: var(--cream-2) !important; }

        /* ── Breadcrumb ── */
        .breadcrumb-item + .breadcrumb-item::before { color: var(--text-muted); }
        .breadcrumb-item a { color: var(--primary-dark); text-decoration: none; font-weight: 600; }
        .breadcrumb-item.active { color: var(--text-muted); }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar       { width: 4px; }
        ::-webkit-scrollbar-track { background: var(--cream-2); }
        ::-webkit-scrollbar-thumb { background: var(--card-border); border-radius: 2px; }

        /* ── Page header ── */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.75rem;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .page-header h2 {
            font-size: 1.4rem;
            font-weight: 800;
            margin: 0;
            color: var(--text-main);
        }
        .page-header .page-sub {
            font-size: .83rem;
            color: var(--text-muted);
            margin: .15rem 0 0;
        }
    </style>
    @stack('styles')
</head>
<body>

{{-- Header --}}
<header class="admin-header">
    <div class="container-fluid d-flex align-items-center justify-content-between w-100">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('home') }}" class="brand-text">
                <i class="bi bi-emoji-dizzy me-2"></i>QLC Admin
            </a>
            <span class="header-panel-badge">PANEL</span>
        </div>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('home') }}" class="btn-header-link">
                <i class="bi bi-arrow-left me-1"></i>Ke Website
            </a>
            <span class="header-user-tag">
                <i class="bi bi-person-circle me-1" style="color: var(--primary);"></i>{{ auth()->user()->name }}
            </span>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="bi bi-box-arrow-right me-1"></i>Keluar
                </button>
            </form>
        </div>
    </div>
</header>

<div class="admin-wrapper">
    {{-- Sidebar --}}
    <nav class="admin-sidebar">
        <div class="sidebar-heading">Utama</div>
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->is('admin') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i>Dashboard
        </a>
        <a href="{{ route('admin.reports.index') }}" class="sidebar-link {{ request()->is('admin/laporan*') ? 'active' : '' }}">
            <i class="bi bi-clipboard-data"></i>Laporan Asesmen
        </a>
        <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->is('admin/pengguna*') ? 'active' : '' }}">
            <i class="bi bi-people"></i>Pengguna
        </a>

        <div class="sidebar-heading">Knowledge Base</div>
        <a href="{{ route('admin.symptoms.index') }}" class="sidebar-link {{ request()->is('admin/gejala*') ? 'active' : '' }}">
            <i class="bi bi-list-stars"></i>Data Gejala
        </a>
        <a href="{{ route('admin.fc-rules.index') }}" class="sidebar-link {{ request()->is('admin/fc-rules*') ? 'active' : '' }}">
            <i class="bi bi-cpu"></i>Rule Forward Chaining
        </a>
        <a href="{{ route('admin.action-plans.index') }}" class="sidebar-link {{ request()->is('admin/action-plans*') ? 'active' : '' }}">
            <i class="bi bi-journal-check"></i>Action Plan
        </a>
        <a href="{{ route('admin.saw-criteria.index') }}" class="sidebar-link {{ request()->is('admin/kriteria-saw*') ? 'active' : '' }}">
            <i class="bi bi-sliders"></i>Kriteria SAW
        </a>
    </nav>

    {{-- Content --}}
    <main class="admin-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
@stack('scripts')
</body>
</html>
