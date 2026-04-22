@extends('layouts.app')
@section('title', 'Reset Password')

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center py-5"
     style="background: radial-gradient(ellipse at 40% 50%, rgba(107,158,114,0.10) 0%, transparent 60%), var(--cream);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-10 col-md-7 col-lg-5 col-xl-4">

                <div class="text-center mb-4 animate-fadeup">
                    <a href="{{ route('home') }}" class="text-decoration-none d-inline-flex align-items-center gap-2 mb-3">
                        <div class="d-flex align-items-center justify-content-center rounded-3"
                             style="width:48px; height:48px; background:linear-gradient(135deg, var(--primary), var(--secondary)); box-shadow: 0 4px 16px rgba(107,158,114,0.35);">
                            <i class="bi bi-emoji-dizzy text-white fs-5"></i>
                        </div>
                        <span class="fw-bold fs-5" style="background:linear-gradient(135deg, var(--primary-dark), var(--primary)); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;">
                            QLC Detector
                        </span>
                    </a>
                    <h1 class="h4 fw-bold mb-1" style="color: var(--text-main);">Buat Password Baru 🔑</h1>
                    <p class="mb-0 small" style="color: var(--text-muted);">Masukkan password baru untuk akunmu.</p>
                </div>

                <div class="card-glass p-4 animate-fadeup" style="animation-delay:.1s;">

                    @if($errors->any())
                        <div class="alert alert-danger mb-3">
                            <i class="bi bi-exclamation-circle me-2"></i>{{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.store') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="bi bi-envelope me-1" style="color: var(--primary);"></i>Email
                            </label>
                            <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $request->email) }}" required readonly
                                   style="background: var(--cream-2); cursor: not-allowed;">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="bi bi-lock me-1" style="color: var(--primary);"></i>Password Baru
                            </label>
                            <div class="position-relative">
                                <input id="password" type="password" name="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Min. 8 karakter" required autocomplete="new-password">
                                <button type="button" class="btn position-absolute end-0 top-50 translate-middle-y pe-3 border-0 bg-transparent"
                                        onclick="togglePassword('password', this)" tabindex="-1">
                                    <i class="bi bi-eye" style="color: var(--text-muted);"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">
                                <i class="bi bi-lock-fill me-1" style="color: var(--primary);"></i>Konfirmasi Password
                            </label>
                            <div class="position-relative">
                                <input id="password_confirmation" type="password" name="password_confirmation"
                                       class="form-control" placeholder="Ulangi password baru" required autocomplete="new-password">
                                <button type="button" class="btn position-absolute end-0 top-50 translate-middle-y pe-3 border-0 bg-transparent"
                                        onclick="togglePassword('password_confirmation', this)" tabindex="-1">
                                    <i class="bi bi-eye" style="color: var(--text-muted);"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary-qlc w-100">
                            <i class="bi bi-check-lg me-2"></i>Simpan Password Baru
                        </button>
                    </form>
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
        icon.style.color = 'var(--primary)';
    } else {
        input.type = 'password';
        icon.className = 'bi bi-eye';
        icon.style.color = 'var(--text-muted)';
    }
}
</script>
@endpush
