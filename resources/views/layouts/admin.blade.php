<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Panel Admin QLC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary:      #6366f1;
            --primary-dark: #4f46e5;
            --secondary:    #8b5cf6;
            --accent:       #06b6d4;
            --dark:         #0f172a;
            --dark-2:       #1e293b;
            --dark-3:       #334155;
            --glass-bg:     rgba(255,255,255,0.05);
            --glass-border: rgba(255,255,255,0.1);
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--dark);
            color: #e2e8f0;
            margin: 0;
        }

        /* ── Base Typography Override ── */
        .text-muted         { color: #94a3b8 !important; }
        p                   { color: #cbd5e1; }
        small, .small       { color: #94a3b8; }
        h1,h2,h3,h4,h5,h6  { color: #f1f5f9; }
        strong              { color: #f1f5f9; }
        td, th              { color: #e2e8f0; }
        li                  { color: #cbd5e1; }
        label, .form-label  { color: #cbd5e1 !important; font-weight: 500; font-size: .88rem; }
        .form-check-label   { color: #cbd5e1 !important; }

        /* ── Header ── */
        .admin-header {
            background: rgba(15,23,42,0.97);
            border-bottom: 1px solid var(--glass-border);
            padding: .8rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(16px);
        }
        .brand-text {
            font-weight: 800;
            font-size: 1.15rem;
            background: linear-gradient(135deg, #6366f1, #06b6d4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ── Layout ── */
        .admin-wrapper  { display: flex; min-height: calc(100vh - 57px); }
        .admin-sidebar  { width: 240px; background: var(--dark-2); border-right: 1px solid var(--glass-border); padding: 1rem .75rem; flex-shrink: 0; }
        .admin-content  { flex: 1; padding: 1.5rem; overflow-x: auto; }

        /* ── Sidebar ── */
        .sidebar-heading {
            font-size: .68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #64748b;
            padding: .5rem .75rem;
            margin-top: .75rem;
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: .6rem;
            padding: .55rem .75rem;
            border-radius: 10px;
            color: #94a3b8;
            font-size: .88rem;
            font-weight: 500;
            text-decoration: none;
            margin-bottom: .15rem;
            transition: all .2s;
        }
        .sidebar-link:hover  { background: rgba(255,255,255,0.07); color: #e2e8f0; }
        .sidebar-link.active { background: rgba(99,102,241,0.18);  color: #a5b4fc; }
        .sidebar-link i      { font-size: 1rem; width: 18px; text-align: center; }

        /* ── Stat Cards ── */
        .card-stat {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 14px;
            padding: 1.25rem;
            color: #e2e8f0;
        }
        .card-stat .small { color: #94a3b8; }

        /* ── Glass Card ── */
        .card-glass {
            background: rgba(255,255,255,0.05);
            border: 1px solid var(--glass-border);
            border-radius: 14px;
            color: #e2e8f0;
        }

        /* ── Form Controls ── */
        .form-control, .form-select {
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.15);
            color: #e2e8f0;
            border-radius: 10px;
        }
        .form-control:focus, .form-select:focus {
            background: rgba(255,255,255,0.1);
            border-color: var(--primary);
            color: #e2e8f0;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.2);
        }
        .form-control::placeholder { color: #475569; }
        .form-select option { background: #1e293b; color: #e2e8f0; }
        .form-range { accent-color: var(--primary); }

        /* ── Buttons ── */
        .btn-primary-admin {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            color: #fff;
            font-weight: 600;
            border-radius: 9px;
            padding: .5rem 1.2rem;
            transition: opacity .2s, transform .15s;
        }
        .btn-primary-admin:hover { opacity: .9; color: #fff; transform: translateY(-1px); }
        .btn-outline-secondary {
            border-color: rgba(255,255,255,0.2) !important;
            color: #cbd5e1 !important;
        }
        .btn-outline-secondary:hover {
            background: rgba(255,255,255,0.1) !important;
            color: #fff !important;
        }

        /* ── Table ── */
        .table-qlc {
            --bs-table-bg: transparent;
            --bs-table-border-color: rgba(255,255,255,0.07);
            color: #e2e8f0;
        }
        .table-qlc thead th {
            color: #94a3b8;
            font-size: .8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .05em;
            border-bottom-color: rgba(255,255,255,0.1);
            padding: .75rem;
        }
        .table-qlc tbody td {
            padding: .75rem;
            vertical-align: middle;
            border-color: rgba(255,255,255,0.05);
            font-size: .88rem;
            color: #e2e8f0;
        }
        .table-qlc tbody tr:hover { background: rgba(255,255,255,0.03); }

        /* ── Alerts ── */
        .alert          { border-radius: 10px; border: 1px solid transparent; }
        .alert-success  { background: rgba(16,185,129,0.12);  color: #a7f3d0; border-color: rgba(16,185,129,0.2); }
        .alert-danger   { background: rgba(239,68,68,0.12);   color: #fca5a5; border-color: rgba(239,68,68,0.2); }
        .alert-warning  { background: rgba(245,158,11,0.12);  color: #fde68a; border-color: rgba(245,158,11,0.2); }
        .alert-info     { background: rgba(6,182,212,0.12);   color: #a5f3fc; border-color: rgba(6,182,212,0.2); }
        .alert a, .alert strong { color: inherit; }

        /* ── Level Badges ── */
        .badge-level-none     { background: rgba(16,185,129,0.15); color: #6ee7b7; }
        .badge-level-mild     { background: rgba(6,182,212,0.15);  color: #67e8f9; }
        .badge-level-moderate { background: rgba(245,158,11,0.15); color: #fcd34d; }
        .badge-level-severe   { background: rgba(239,68,68,0.15);  color: #fca5a5; }

        /* ── Dropdown ── */
        .dropdown-menu       { background: var(--dark-2) !important; border: 1px solid var(--glass-border) !important; }
        .dropdown-item       { color: #cbd5e1 !important; }
        .dropdown-item:hover { background: rgba(255,255,255,0.08) !important; color: #fff !important; }
        .dropdown-item.text-danger  { color: #fca5a5 !important; }
        .dropdown-divider    { border-color: rgba(255,255,255,0.1) !important; }

        /* ── Pagination ── */
        .pagination .page-link          { background: rgba(255,255,255,0.06); border-color: rgba(255,255,255,0.12); color: #94a3b8; }
        .pagination .page-link:hover    { background: rgba(99,102,241,0.2);   color: #a5b4fc; }
        .pagination .page-item.active .page-link   { background: var(--primary); border-color: var(--primary); color: #fff; }
        .pagination .page-item.disabled .page-link { background: rgba(255,255,255,0.03); color: #475569; }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar       { width: 4px; }
        ::-webkit-scrollbar-track { background: var(--dark-2); }
        ::-webkit-scrollbar-thumb { background: var(--dark-3); border-radius: 2px; }
    </style>
    @stack('styles')
</head>
<body>

{{-- Header --}}
<header class="admin-header">
    <div class="d-flex align-items-center justify-content-between px-3">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('home') }}" class="brand-text text-decoration-none">
                <i class="bi bi-brain me-2"></i>QLC Admin
            </a>
            <span class="badge" style="background:rgba(245,158,11,0.2); color:#fcd34d; font-size:.7rem;">Panel</span>
        </div>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('home') }}" class="small text-decoration-none" style="color:#94a3b8;">
                <i class="bi bi-arrow-left me-1"></i>Ke Website
            </a>
            <span class="small" style="color:#94a3b8;">
                <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}
            </span>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm" style="background:rgba(239,68,68,0.15); color:#fca5a5; border:1px solid rgba(239,68,68,0.2); font-size:.78rem;">
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
        <a href="{{ route('admin.dashboard') }}"    class="sidebar-link {{ request()->is('admin') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i>Dashboard
        </a>
        <a href="{{ route('admin.reports.index') }}" class="sidebar-link {{ request()->is('admin/laporan*') ? 'active' : '' }}">
            <i class="bi bi-clipboard-data"></i>Laporan Asesmen
        </a>
        <a href="{{ route('admin.users.index') }}"   class="sidebar-link {{ request()->is('admin/pengguna*') ? 'active' : '' }}">
            <i class="bi bi-people"></i>Pengguna
        </a>

        <div class="sidebar-heading">Knowledge Base</div>
        <a href="{{ route('admin.symptoms.index') }}"    class="sidebar-link {{ request()->is('admin/gejala*') ? 'active' : '' }}">
            <i class="bi bi-list-stars"></i>Data Gejala
        </a>
        <a href="{{ route('admin.fc-rules.index') }}"    class="sidebar-link {{ request()->is('admin/fc-rules*') ? 'active' : '' }}">
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
                <button type="button" class="btn-close" style="filter:invert(1)" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" style="filter:invert(1)" data-bs-dismiss="alert"></button>
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
