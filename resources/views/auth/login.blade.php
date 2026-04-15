@extends('layouts.app')
@section('title', 'Masuk')

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center py-5" style="background: radial-gradient(ellipse at 30% 50%, rgba(99,102,241,0.12) 0%, transparent 60%), radial-gradient(ellipse at 80% 20%, rgba(139,92,246,0.10) 0%, transparent 50%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-10 col-md-7 col-lg-5 col-xl-4">

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
                    <h1 class="h4 fw-bold mb-1" style="color:#f1f5f9;">Selamat Datang Kembali</h1>
                    <p class="mb-0" style="color:#94a3b8; font-size:.92rem;">Masuk untuk melanjutkan perjalananmu</p>
                </div>

                {{-- Card --}}
                <div class="card-glass p-4 animate-fadeup" style="animation-delay:.1s;">

                    {{-- Session Status --}}
                    @if(session('status'))
                        <div class="alert alert-success mb-3">{{ session('status') }}</div>
                    @endif

                    {{-- Errors --}}
                    @if($errors->any())
                        <div class="alert alert-danger mb-3">
                            <i class="bi bi-exclamation-circle me-2"></i>
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

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
                                autofocus
                                autocomplete="username"
                            >
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label for="password" class="form-label mb-0">
                                    <i class="bi bi-lock me-1" style="color:#a5b4fc;"></i>Password
                                </label>
                                @if(Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="small text-decoration-none" style="color:#a5b4fc;">
                                        Lupa password?
                                    </a>
                                @endif
                            </div>
                            <div class="position-relative">
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="••••••••"
                                    required
                                    autocomplete="current-password"
                                >
                                <button type="button" class="btn position-absolute end-0 top-50 translate-middle-y pe-3 border-0 bg-transparent"
                                        onclick="togglePassword('password', this)" tabindex="-1">
                                    <i class="bi bi-eye" style="color:#64748b;"></i>
                                </button>
                            </div>
                        </div>

                        {{-- Remember Me --}}
                        <div class="mb-4">
                            <div class="form-check">
                                <input id="remember_me" type="checkbox" class="form-check-input" name="remember"
                                       style="background-color:rgba(255,255,255,0.08); border-color:rgba(255,255,255,0.2);">
                                <label for="remember_me" class="form-check-label small">Ingat saya di perangkat ini</label>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="btn btn-primary-qlc w-100 mb-3">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                        </button>

                        {{-- Divider --}}
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <hr class="flex-grow-1" style="border-color:rgba(255,255,255,0.1);">
                            <span class="small" style="color:#475569;">atau</span>
                            <hr class="flex-grow-1" style="border-color:rgba(255,255,255,0.1);">
                        </div>

                        {{-- Guest Mode --}}
                        <a href="{{ route('assessment.intro') }}" class="btn btn-outline-qlc w-100 mb-3">
                            <i class="bi bi-incognito me-2"></i>Lanjut sebagai Tamu
                        </a>

                        {{-- Register Link --}}
                        <p class="text-center mb-0 small" style="color:#94a3b8;">
                            Belum punya akun?
                            <a href="{{ route('register') }}" class="fw-semibold text-decoration-none" style="color:#a5b4fc;">
                                Daftar sekarang
                            </a>
                        </p>
                    </form>
                </div>

                {{-- Note --}}
                <p class="text-center small mt-4" style="color:#475569;">
                    <i class="bi bi-shield-lock me-1"></i>
                    Data kamu dilindungi dan tidak dibagikan ke pihak ketiga.
                </p>

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
