@extends('layouts.app')
@section('title', 'Beranda')

@section('content')

{{-- Hero Section --}}
<section class="position-relative overflow-hidden" style="min-height:90vh; display:flex; align-items:center;">
    {{-- Background Gradient --}}
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: radial-gradient(ellipse at 30% 50%, rgba(122,158,126,0.13) 0%, transparent 60%), radial-gradient(ellipse at 80% 20%, rgba(157,186,127,0.10) 0%, transparent 50%); pointer-events:none;"></div>

    <div class="container position-relative z-1">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 animate-fadeup">
                <span class="badge rounded-pill px-3 py-2 mb-4" style="background:rgba(122,158,126,0.2); color:#a8c5aa; font-size:.85rem; border:1px solid rgba(122,158,126,0.3);">
                    <i class="bi bi-shield-check me-2"></i>Self-Assessment Tool · Berbasis Bukti Ilmiah
                </span>
                <h1 class="display-5 fw-800 lh-1 mb-4" style="font-weight:800;">
                    Apakah Kamu Sedang Mengalami
                    <span style="background: linear-gradient(135deg, #7a9e7e, #c8b89a); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;">
                        Quarter-Life Crisis?
                    </span>
                </h1>
                <p class="text-muted fs-5 mb-4" style="line-height:1.7;">
                    Deteksi dini tingkat QLC-mu menggunakan metode <strong style="color:#a8c5aa;">Forward Chaining</strong> berbasis 20 indikator ilmiah, dan dapatkan rekomendasi action plan personal terurut menggunakan <strong style="color:#a8c5aa;">Simple Additive Weighting (SAW)</strong>.
                </p>

                {{-- Stats --}}
                <div class="row g-3 mb-5">
                    <div class="col-4">
                        <div class="card-glass p-3 text-center">
                            <div class="fs-4 fw-bold" style="color:#a8c5aa;">20</div>
                            <div class="small text-muted">Indikator QLC</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card-glass p-3 text-center">
                            <div class="fs-4 fw-bold" style="color:#c8b89a;">5</div>
                            <div class="small text-muted">Domain Gejala</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card-glass p-3 text-center">
                            <div class="fs-4 fw-bold" style="color:#9dba7f;">12</div>
                            <div class="small text-muted">Action Plan</div>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('assessment.intro') }}" class="btn btn-primary-qlc btn-lg pulse-glow">
                        <i class="bi bi-play-circle me-2"></i>Mulai Tes Sekarang — Gratis
                    </a>
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-outline-qlc btn-lg">
                            <i class="bi bi-person-plus me-2"></i>Buat Akun
                        </a>
                    @endguest
                </div>

                <p class="text-muted small mt-3">
                    <i class="bi bi-clock me-1"></i>Waktu pengisian ±7-10 menit · Non-klinis · Gratis selamanya
                </p>
            </div>

            <div class="col-lg-6 text-center animate-fadeup" style="animation-delay:.2s;">
                <div class="card-glass p-4 mx-auto" style="max-width:380px;">
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small text-muted">Skor QLC Contoh</span>
                            <span class="badge" style="background:rgba(201,163,78,0.2); color:#e8d09a;">QLC Sedang</span>
                        </div>
                        <div class="display-4 fw-bold" style="color:#e8d09a;">47<small class="fs-4 text-muted">/80</small></div>
                    </div>
                    {{-- Domain bars contoh --}}
                    @php
                        $demoDomains = [
                            ['name'=>'Identitas Diri',     'pct'=>75, 'color'=>'#7a9e7e'],
                            ['name'=>'Karir & Tujuan',     'pct'=>85, 'color'=>'#9dba7f'],
                            ['name'=>'Finansial',          'pct'=>60, 'color'=>'#c8b89a'],
                            ['name'=>'Sosial & Relasi',    'pct'=>50, 'color'=>'#6eaa6e'],
                            ['name'=>'Psikologis',         'pct'=>45, 'color'=>'#c9a34e'],
                        ];
                    @endphp
                    @foreach($demoDomains as $d)
                        <div class="mb-2">
                            <div class="d-flex justify-content-between small mb-1">
                                <span class="text-muted">{{ $d['name'] }}</span>
                                <span style="color:{{ $d['color'] }}">{{ $d['pct'] }}%</span>
                            </div>
                            <div class="progress" style="height:6px; background:rgba(200,184,154,0.1);">
                                <div class="progress-bar" style="width:{{ $d['pct'] }}%; background:{{ $d['color'] }};"></div>
                            </div>
                        </div>
                    @endforeach
                    <div class="mt-4 pt-3 border-top border-secondary">
                        <div class="small text-muted mb-3">Top Rekomendasi Action Plan</div>
                        @foreach(['Journaling Klarifikasi Nilai','SMART Goals Jangka Pendek','Restrukturisasi Kognitif'] as $i => $ap)
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:26px; height:26px; background:rgba(122,158,126,0.2); color:#a8c5aa; font-size:.75rem; font-weight:700;">{{ $i+1 }}</div>
                                <span class="small">{{ $ap }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Cara Kerja --}}
<section class="py-5" style="background:var(--cream-2);">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Bagaimana Cara Kerjanya?</h2>
            <p class="text-muted">Proses deteksi 3 langkah berbasis metode ilmiah</p>
        </div>
        <div class="row g-4 justify-content-center">
            @php
                $steps = [
                    ['icon'=>'bi-clipboard-check', 'color'=>'#7a9e7e', 'num'=>'01', 'title'=>'Isi Kuesioner', 'desc'=>'20 pernyataan dalam 5 domain QLC. Skala Likert 1–5. Tidak ada jawaban benar/salah.'],
                    ['icon'=>'bi-cpu',             'color'=>'#9dba7f', 'num'=>'02', 'title'=>'Forward Chaining', 'desc'=>'Mesin inferensi membandingkan jawabanmu dengan rule base untuk menentukan level QLC.'],
                    ['icon'=>'bi-bar-chart-steps', 'color'=>'#c8b89a', 'num'=>'03', 'title'=>'SAW Meranking', 'desc'=>'12 action plan diranking menggunakan 4 kriteria terbobot untuk hasil yang paling personal.'],
                ];
            @endphp
            @foreach($steps as $s)
                <div class="col-md-4">
                    <div class="card-glass p-4 h-100 text-center">
                        <div class="mb-3">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-3 mb-3" style="width:64px; height:64px; background: rgba({{ $s['num']=='01'?'122,158,126':($s['num']=='02'?'157,186,127':'200,184,154') }}, 0.15);">
                                <i class="{{ $s['icon'] }} fs-3" style="color:{{ $s['color'] }};"></i>
                            </div>
                            <div class="small fw-bold mb-2" style="color:{{ $s['color'] }};">LANGKAH {{ $s['num'] }}</div>
                        </div>
                        <h5 class="fw-bold mb-2">{{ $s['title'] }}</h5>
                        <p class="text-muted small mb-0">{{ $s['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Disclaimer --}}
<section class="py-4">
    <div class="container">
        <div class="alert alert-warning d-flex gap-3 align-items-start">
            <i class="bi bi-exclamation-triangle-fill fs-5 flex-shrink-0 mt-1"></i>
            <div>
                <strong>Perhatian Penting:</strong> Sistem ini adalah alat bantu penilaian mandiri (self-assessment tool) dan <strong>bukan pengganti diagnosis klinis</strong> oleh tenaga psikologi profesional. Jika kamu merasa kondisimu sangat berat, segera hubungi psikolog atau konselor terdekat.
            </div>
        </div>
    </div>
</section>

@endsection
