@extends('layouts.app')
@section('title', 'Mulai Tes QLC')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card-glass p-5 text-center animate-fadeup">

                {{-- Icon --}}
                <div class="mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-4" style="width:88px; height:88px; background: linear-gradient(135deg, rgba(99,102,241,0.25), rgba(139,92,246,0.25));">
                        <i class="bi bi-brain fs-1" style="color:#a5b4fc;"></i>
                    </div>
                </div>

                <h1 class="h3 fw-bold mb-2">Tes Quarter-Life Crisis</h1>
                <p class="text-muted mb-4">Sistem Pendukung Keputusan berbasis Forward Chaining & SAW</p>

                {{-- Info Cards --}}
                <div class="row g-3 mb-5">
                    <div class="col-sm-4">
                        <div class="p-3 rounded-3" style="background:rgba(99,102,241,0.1); border:1px solid rgba(99,102,241,0.2);">
                            <i class="bi bi-list-check fs-4 mb-2 d-block" style="color:#a5b4fc;"></i>
                            <div class="fw-semibold">20 Pernyataan</div>
                            <div class="small text-muted">5 domain QLC</div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="p-3 rounded-3" style="background:rgba(6,182,212,0.1); border:1px solid rgba(6,182,212,0.2);">
                            <i class="bi bi-clock fs-4 mb-2 d-block" style="color:#67e8f9;"></i>
                            <div class="fw-semibold">7–10 Menit</div>
                            <div class="small text-muted">Waktu pengisian</div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="p-3 rounded-3" style="background:rgba(16,185,129,0.1); border:1px solid rgba(16,185,129,0.2);">
                            <i class="bi bi-lock fs-4 mb-2 d-block" style="color:#6ee7b7;"></i>
                            <div class="fw-semibold">Anonim & Aman</div>
                            <div class="small text-muted">Data terlindungi</div>
                        </div>
                    </div>
                </div>

                {{-- Panduan --}}
                <div class="text-start mb-5 p-4 rounded-3" style="background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.08);">
                    <h6 class="fw-bold mb-3"><i class="bi bi-info-circle me-2" style="color:#67e8f9;"></i>Petunjuk Pengisian</h6>
                    <ul class="text-muted mb-0 ps-3" style="line-height:2;">
                        <li>Bacalah setiap pernyataan dengan <strong class="text-light">seksama</strong> sebelum menjawab.</li>
                        <li>Pilih jawaban sesuai kondisi yang kamu rasakan <strong class="text-light">dalam 1 bulan terakhir</strong>.</li>
                        <li>Skala jawaban: <strong class="text-light">1 = Tidak Pernah</strong> hingga <strong class="text-light">5 = Selalu</strong>.</li>
                        <li>Tidak ada jawaban benar atau salah — jawab sejujurnya.</li>
                        <li>Semua pernyataan dalam satu halaman wajib diisi sebelum lanjut.</li>
                    </ul>
                </div>

                {{-- Auth Info --}}
                @guest
                    <div class="alert alert-info text-start mb-4 d-flex gap-2">
                        <i class="bi bi-person-circle fs-5 flex-shrink-0"></i>
                        <div>
                            <strong>Kamu mengisi sebagai Tamu.</strong> Riwayat hanya tersimpan sementara.
                            <a href="{{ route('register') }}" class="alert-link">Daftar akun</a> untuk menyimpan riwayat permanen dan memantau perkembanganmu.
                        </div>
                    </div>
                @endauth

                {{-- Disclaimer --}}
                <p class="small text-muted mb-4">
                    <i class="bi bi-exclamation-triangle me-1 text-warning"></i>
                    Ini adalah alat self-assessment dan <strong>bukan pengganti diagnosis klinis</strong>.
                </p>

                {{-- CTA --}}
                <form method="POST" action="{{ route('assessment.start') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary-qlc btn-lg w-100 pulse-glow">
                        <i class="bi bi-play-circle me-2"></i>Mulai Tes Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
