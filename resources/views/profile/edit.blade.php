@extends('layouts.app')
@section('title', 'Profil Saya')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="mb-4 d-flex align-items-center gap-3 animate-fadeup">
                <div class="d-flex align-items-center justify-content-center rounded-circle" style="width:64px; height:64px; background:rgba(99,102,241,0.15); border:1px solid rgba(99,102,241,0.3);">
                    <i class="bi bi-person-circle fs-1" style="color:#a5b4fc;"></i>
                </div>
                <div>
                    <h2 class="fw-bold mb-1">Pengaturan Profil</h2>
                    <p class="text-muted mb-0">Perbarui informasi profil dan kata sandi akunmu.</p>
                </div>
            </div>

            @if(session('status') === 'profile-updated')
                <div class="alert alert-success alert-dismissible fade show mb-4 animate-fadeup">
                    <i class="bi bi-check-circle me-2"></i>Informasi profil berhasil diperbarui.
                    <button type="button" class="btn-close" style="filter:invert(1)" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('status') === 'password-updated')
                <div class="alert alert-success alert-dismissible fade show mb-4 animate-fadeup">
                    <i class="bi bi-shield-lock me-2"></i>Kata sandi berhasil diperbarui.
                    <button type="button" class="btn-close" style="filter:invert(1)" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- 1. Update Profile Info --}}
            <div class="card-glass p-4 mb-4 animate-fadeup" style="animation-delay:.1s">
                <h5 class="fw-bold mb-1"><i class="bi bi-person-vcard me-2" style="color:#a5b4fc;"></i>Informasi Profil</h5>
                <p class="text-muted small mb-4">Perbarui nama lengkap dan alamat email akunmu.</p>

                <form method="post" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="form-label">Alamat Email</label>
                        <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required autocomplete="username">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror

                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div class="mt-2 text-warning small">
                                Email kamu belum diverifikasi.
                                <button form="send-verification" class="btn btn-link p-0 m-0 align-baseline text-warning">Klik di sini untuk mengirim ulang email verifikasi.</button>
                            </div>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary-qlc px-4">Simpan Perubahan</button>
                    
                    @if (session('status') === 'profile-updated')
                        <span class="small ms-3 text-success fade show">Sedang disimpan...</span>
                    @endif
                </form>
            </div>

            {{-- 2. Update Password --}}
            <div class="card-glass p-4 mb-4 animate-fadeup" style="animation-delay:.2s">
                <h5 class="fw-bold mb-1"><i class="bi bi-shield-lock me-2" style="color:#67e8f9;"></i>Perbarui Kata Sandi</h5>
                <p class="text-muted small mb-4">Pastikan akun menggunakan kata sandi yang panjang dan acak agar tetap aman.</p>

                <form method="post" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')

                    <div class="mb-3">
                        <label for="update_password_current_password" class="form-label">Kata Sandi Saat Ini</label>
                        <input id="update_password_current_password" name="current_password" type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" autocomplete="current-password">
                        @error('current_password', 'updatePassword')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="update_password_password" class="form-label">Kata Sandi Baru</label>
                        <input id="update_password_password" name="password" type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" autocomplete="new-password">
                        @error('password', 'updatePassword')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label for="update_password_password_confirmation" class="form-label">Konfirmasi Kata Sandi Baru</label>
                        <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary-qlc px-4" style="background:linear-gradient(135deg, #06b6d4, #3b82f6)">Perbarui Kata Sandi</button>
                </form>
            </div>

        </div>
    </div>
</div>

{{-- Hidden form for email verification --}}
<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>

@endsection
