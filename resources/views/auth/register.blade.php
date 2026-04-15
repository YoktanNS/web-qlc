@extends('layouts.app')
@section('title', 'Daftar Akun')

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center py-5" style="background: radial-gradient(ellipse at 70% 50%, rgba(139,92,246,0.12) 0%, transparent 60%), radial-gradient(ellipse at 20% 80%, rgba(6,182,212,0.08) 0%, transparent 50%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5">

                {{-- Logo & Header --}}
                <div class="text-center mb-4 animate-fadeup">
                    <a href="{{ route('home') }}" class="text-decoration-none d-inline-flex align-items-center gap-2 mb-3">
                        <div class="d-flex align-items-center justify-content-center rounded-3"
                             style="width:48px; height:48px; background:linear-gradient(135deg, #6366f1, #8b5cf6);">
                            <i class="bi bi-brain text-white fs-5"></i>
                        </div>
                        <span class="fw-bold fs-5" style="background:linear-gradient(135deg,#6366f1,#06b6d4); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;">
                            QLC Detector
                        </span>
                    </a>
                    <h1 class="h4 fw-bold mb-1" style="color:#f1f5f9;">Buat Akun Baru</h1>
                    <p class="mb-0" style="color:#94a3b8; font-size:.92rem;">Simpan riwayat tes & pantau perkembanganmu</p>
                </div>

                {{-- Card --}}
                <div class="card-glass p-4 animate-fadeup" style="animation-delay:.1s;">

                    @if($errors->any())
                        <div class="alert alert-danger mb-3">
                            <i class="bi bi-exclamation-circle me-2"></i>
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        {{-- Nama --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                <i class="bi bi-person me-1" style="color:#a5b4fc;"></i>Nama Lengkap
                            </label>
                            <input
                                id="name"
                                type="text"
                                name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}"
                                placeholder="Nama kamu"
                                required
                                autofocus
                                autocomplete="name"
                            >
                            @error('name')
                                <div class="invalid-feedback" style="color:#fca5a5;">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="bi bi-envelope me-1" style="color:#a5b4fc;"></i>Alamat Email
                            </label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}"
                                placeholder="email@contoh.com"
                                required
                                autocomplete="username"
                            >
                            @error('email')
                                <div class="invalid-feedback" style="color:#fca5a5;">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="bi bi-lock me-1" style="color:#a5b4fc;"></i>Password
                            </label>
                            <div class="position-relative">
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Min. 8 karakter"
                                    required
                                    autocomplete="new-password"
                                >
                                <button type="button" class="btn position-absolute end-0 top-50 translate-middle-y pe-3 border-0 bg-transparent"
                                        onclick="togglePassword('password', this)" tabindex="-1">
                                    <i class="bi bi-eye" style="color:#64748b;"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="mt-1 small" style="color:#fca5a5;">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Konfirmasi Password --}}
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">
                                <i class="bi bi-lock-fill me-1" style="color:#a5b4fc;"></i>Konfirmasi Password
                            </label>
                            <div class="position-relative">
                                <input
                                    id="password_confirmation"
                                    type="password"
                                    name="password_confirmation"
                                    class="form-control"
                                    placeholder="Ulangi password"
                                    required
                                    autocomplete="new-password"
                                >
                                <button type="button" class="btn position-absolute end-0 top-50 translate-middle-y pe-3 border-0 bg-transparent"
                                        onclick="togglePassword('password_confirmation', this)" tabindex="-1">
                                    <i class="bi bi-eye" style="color:#64748b;"></i>
                                </button>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="btn btn-primary-qlc w-100 mb-3">
                            <i class="bi bi-person-plus me-2"></i>Buat Akun
                        </button>

                        {{-- Login Link --}}
                        <p class="text-center mb-0 small" style="color:#94a3b8;">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="fw-semibold text-decoration-none" style="color:#a5b4fc;">
                                Masuk di sini
                            </a>
                        </p>
                    </form>
                </div>

                {{-- Benefits --}}
                <div class="row g-2 mt-3">
                    @foreach([
                        ['bi-clock-history', 'Simpan riwayat tes'],
                        ['bi-graph-up', 'Pantau progres'],
                        ['bi-shield-lock', 'Data aman'],
                    ] as $b)
                        <div class="col-4 text-center">
                            <div class="small" style="color:#475569;">
                                <i class="bi {{ $b[0] }} d-block mb-1"></i>{{ $b[1] }}
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function togglePassword(id, btn) {
    const input = document.getElementById(id);
    const icon  = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'bi bi-eye-slash';
        icon.style.color = '#a5b4fc';
    } else {
        input.type = 'password';
        icon.className = 'bi bi-eye';
        icon.style.color = '#64748b';
    }
}
</script>
@endpush
