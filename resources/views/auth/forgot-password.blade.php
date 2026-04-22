@extends('layouts.app')
@section('title', 'Lupa Password')

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
                    <div class="d-flex align-items-center justify-content-center rounded-3 mx-auto mb-3"
                         style="width:56px; height:56px; background: var(--primary-light);">
                        <i class="bi bi-key fs-4" style="color: var(--primary-dark);"></i>
                    </div>
                    <h1 class="h4 fw-bold mb-1" style="color: var(--text-main);">Lupa Password?</h1>
                    <p class="mb-0 small" style="color: var(--text-muted);">
                        Masukkan email kamu dan kami akan mengirimkan link reset password.
                    </p>
                </div>

                <div class="card-glass p-4 animate-fadeup" style="animation-delay:.1s;">

                    @if(session('status'))
                        <div class="alert alert-success mb-3">
                            <i class="bi bi-check-circle me-2"></i>{{ session('status') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger mb-3">
                            <i class="bi bi-exclamation-circle me-2"></i>{{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="form-label">
                                <i class="bi bi-envelope me-1" style="color: var(--primary);"></i>Alamat Email
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
                            >
                        </div>

                        <button type="submit" class="btn btn-primary-qlc w-100 mb-3">
                            <i class="bi bi-send me-2"></i>Kirim Link Reset
                        </button>

                        <p class="text-center mb-0 small" style="color: var(--text-muted);">
                            Ingat password?
                            <a href="{{ route('login') }}" class="fw-semibold text-decoration-none" style="color: var(--primary-dark);">Kembali masuk</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
