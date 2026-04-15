@extends('layouts.app')
@section('title', 'Hasil Asesmen QLC')

@section('content')
<div class="container py-5">

    {{-- Header Hasil --}}
    <div class="row justify-content-center mb-4">
        <div class="col-lg-10">
            <div class="card-glass p-5 text-center animate-fadeup position-relative overflow-hidden">

                {{-- Background Glow --}}
                <div class="position-absolute top-0 start-0 w-100 h-100" style="background: radial-gradient(ellipse at 50% 0%, rgba({{ $level->code === 'severe' ? '239,68,68' : ($level->code === 'moderate' ? '245,158,11' : ($level->code === 'mild' ? '6,182,212' : '16,185,129')) }}, 0.08) 0%, transparent 70%); pointer-events:none;"></div>

                <div class="position-relative">
                    {{-- Icon Level --}}
                    <div class="mb-3">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-4 mb-3"
                             style="width:80px; height:80px; background: rgba({{ $level->code === 'severe' ? '239,68,68' : ($level->code === 'moderate' ? '245,158,11' : ($level->code === 'mild' ? '6,182,212' : '16,185,129')) }}, 0.15);">
                            <i class="{{ $level->icon ?? 'bi-circle' }} fs-2" style="color: var(--{{ $level->color_class === 'success' ? 'success' : ($level->color_class === 'warning' ? 'warning' : ($level->color_class === 'danger' ? 'danger' : 'accent')) }});"></i>
                        </div>
                    </div>

                    <span class="badge px-4 py-2 rounded-pill mb-3 fs-6 level-badge-{{ $level->code }}">
                        {{ $level->name }}
                    </span>

                    <h1 class="display-4 fw-bold mb-1">
                        {{ $result->total_score }}<small class="fs-3 text-muted">/80</small>
                    </h1>
                    <p class="text-muted mb-4">Total Skor Asesmen</p>

                    <p class="text-light mb-4 mx-auto" style="max-width:600px; line-height:1.7;">
                        {{ $level->description }}
                    </p>

                    @if($level->advice)
                        <div class="alert d-inline-block text-start px-4 py-3 rounded-3 mb-0 level-badge-{{ $level->code }}" style="max-width:600px;">
                            <i class="bi bi-lightbulb me-2"></i>{{ $level->advice }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 justify-content-center">
        <div class="col-lg-7">

            {{-- Skor per Domain --}}
            <div class="card-glass p-4 mb-4 animate-fadeup" style="animation-delay:.1s">
                <h5 class="fw-bold mb-4">
                    <i class="bi bi-bar-chart me-2" style="color:#a5b4fc;"></i>Skor per Domain
                </h5>
                @foreach($domainScores as $code => $data)
                    @php
                        $pct = $data['max'] > 0 ? round($data['score'] / $data['max'] * 100) : 0;
                        $barColor = $pct >= 75 ? '#ef4444' : ($pct >= 50 ? '#f59e0b' : ($pct >= 25 ? '#06b6d4' : '#10b981'));
                    @endphp
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <div>
                                <span class="badge me-2" style="background:rgba(99,102,241,0.15); color:#a5b4fc; font-size:.7rem;">{{ $code }}</span>
                                <span class="small fw-medium">{{ $data['name'] }}</span>
                            </div>
                            <span class="small fw-bold" style="color:{{ $barColor }};">{{ $data['score'] }}/{{ $data['max'] }}</span>
                        </div>
                        <div class="progress" style="height:8px; background:rgba(255,255,255,0.08); border-radius:99px;">
                            <div class="progress-bar" style="width:{{ $pct }}%; background:{{ $barColor }}; border-radius:99px; transition:width 1s ease;"></div>
                        </div>
                    </div>
                @endforeach
                <div class="mt-3 pt-3 border-top border-secondary">
                    <small class="text-muted">
                        <i class="bi bi-pin-angle me-1" style="color:#fcd34d;"></i>
                        Domain Dominan: <strong class="text-light">{{ $result->dominant_domain }}</strong>
                    </small>
                </div>
            </div>

            {{-- Rule FC yang Aktif --}}
            @if(count($fcRulesFired) > 0)
                <div class="card-glass p-4 mb-4 animate-fadeup" style="animation-delay:.2s">
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-cpu me-2" style="color:#67e8f9;"></i>Proses Forward Chaining
                    </h5>
                    <p class="text-muted small mb-3">Rule-rule berikut terpenuhi dan mempengaruhi penentuan level akhirmu:</p>
                    @foreach($fcRulesFired as $ruleCode)
                        <div class="d-flex align-items-center gap-2 mb-2 p-2 rounded-3" style="background:rgba(6,182,212,0.08); border:1px solid rgba(6,182,212,0.2);">
                            <i class="bi bi-check-lg" style="color:#67e8f9;"></i>
                            <span class="small"><strong>{{ $ruleCode }}</strong></span>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Aksi --}}
            <div class="d-flex flex-wrap gap-3">
                <a href="{{ route('assessment.intro') }}" class="btn btn-outline-qlc">
                    <i class="bi bi-arrow-repeat me-2"></i>Tes Ulang
                </a>
                <a href="{{ route('sus.form', ['result_id' => $result->id]) }}" class="btn btn-outline-secondary">
                    <i class="bi bi-star me-2"></i>Isi Form SUS
                </a>
                @auth
                    <a href="{{ route('result.history') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-clock-history me-2"></i>Riwayat Tes
                    </a>
                @endauth
            </div>
        </div>

        {{-- Rekomendasi Action Plan --}}
        <div class="col-lg-7 mt-4" id="recommendations">
            @if($level->allow_action_plan && $recommendations->count() > 0)
                <div class="animate-fadeup" style="animation-delay:.3s">
                    <h4 class="fw-bold mb-1">
                        <i class="bi bi-bar-chart-steps me-2" style="color:#a5b4fc;"></i>
                        Rekomendasi Action Plan
                    </h4>
                    <p class="text-muted small mb-4">Diranking menggunakan metode SAW berdasarkan profil gejalamu</p>

                    @foreach($recommendations->take(5) as $rec)
                        @php
                            $ap = $rec->actionPlan;
                            $catColors = ['cognitive'=>'#6366f1','journaling'=>'#8b5cf6','behavioral'=>'#06b6d4','mindfulness'=>'#10b981','social'=>'#f59e0b'];
                            $color = $catColors[$ap->category] ?? '#6366f1';
                        @endphp
                        <div class="card-glass p-4 mb-3 animate-fadeup" style="animation-delay:{{ .3 + $loop->index * 0.07 }}s">
                            <div class="d-flex gap-3">
                                {{-- Rank --}}
                                <div class="flex-shrink-0">
                                    <div class="d-flex align-items-center justify-content-center rounded-circle fw-bold"
                                         style="width:44px; height:44px; background: rgba({{ $rec->rank === 1 ? '245,158,11' : ($rec->rank === 2 ? '148,163,184' : '99,102,241') }}, 0.15); color: {{ $rec->rank === 1 ? '#fcd34d' : ($rec->rank === 2 ? '#94a3b8' : '#a5b4fc') }}; font-size:1.1rem;">
                                        @if($rec->rank === 1) <i class="bi bi-trophy"></i>
                                        @else {{ $rec->rank }}
                                        @endif
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex flex-wrap gap-2 align-items-center mb-1">
                                        <h6 class="fw-bold mb-0">{{ $ap->name }}</h6>
                                        <span class="badge rounded-pill" style="background:rgba({{ $ap->category==='mindfulness'?'16,185,129':($ap->category==='social'?'245,158,11':($ap->category==='journaling'?'139,92,246':($ap->category==='behavioral'?'6,182,212':'99,102,241'))) }}, 0.2); color:{{ $color }}; font-size:.7rem;">
                                            {{ $ap->category_label }}
                                        </span>
                                        @if($ap->duration_minutes)
                                            <span class="text-muted small"><i class="bi bi-clock me-1"></i>{{ $ap->duration_minutes }} menit</span>
                                        @endif
                                    </div>
                                    <p class="text-muted small mb-2">
                                        {{ Str::limit($ap->description, 100) }}
                                    </p>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="small" style="color:{{ $color }};">
                                            Skor SAW: <strong>{{ number_format($rec->saw_final_score, 4) }}</strong>
                                        </span>
                                        <button class="btn btn-sm rounded-3" style="background:rgba(99,102,241,0.15); color:#a5b4fc; font-size:.78rem;" type="button" data-bs-toggle="collapse" data-bs-target="#ap{{ $ap->id }}">
                                            <i class="bi bi-arrows-expand me-1"></i>Selengkapnya
                                        </button>
                                    </div>

                                    {{-- Full Detail Collapse --}}
                                    <div class="collapse mt-3" id="ap{{ $ap->id }}">
                                        <div class="p-3 rounded-3" style="background:rgba(255,255,255,0.04);">
                                            <p class="small text-light mb-2" style="line-height:1.6;">{{ $ap->description }}</p>
                                            @if($ap->how_to)
                                                <h6 class="small fw-bold text-muted mt-3 mb-1"><i class="bi bi-check2-square me-1"></i>Cara Melakukan:</h6>
                                                <div class="small text-muted" style="white-space:pre-line; line-height:1.7;">{{ $ap->how_to }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{-- SAW Info --}}
                    <div class="p-3 rounded-3 mt-2" style="background:rgba(6,182,212,0.06); border:1px solid rgba(6,182,212,0.15);">
                        <small class="text-muted">
                            <i class="bi bi-info-circle me-1" style="color:#67e8f9;"></i>
                            Ranking dihasilkan oleh metode <strong class="text-info">Simple Additive Weighting (SAW)</strong> berdasarkan 4 kriteria:
                            Relevansi Gejala (35%), Kemudahan (25%), Efektivitas Literatur (25%), Kesesuaian Usia (15%).
                        </small>
                    </div>
                </div>

            @elseif($level->code === 'severe')
                <div class="card-glass p-5 text-center animate-fadeup" style="animation-delay:.3s; border-color:rgba(239,68,68,0.3);">
                    <i class="bi bi-heart-pulse fs-1 mb-3 d-block" style="color:#fca5a5;"></i>
                    <h5 class="fw-bold mb-3">Segera Cari Bantuan Profesional</h5>
                    <p class="text-muted mb-4">
                        Tingkat QLC yang kamu alami memerlukan pendampingan dari psikolog atau konselor profesional. Ini adalah langkah paling tepat dan terkuat yang bisa kamu ambil saat ini.
                    </p>
                    <div class="d-flex flex-wrap gap-3 justify-content-center">
                        <a href="https://www.halodoc.com/artikel/psikolog" target="_blank" class="btn btn-outline-danger">
                            <i class="bi bi-telephone me-2"></i>Cari Psikolog Online
                        </a>
                        <a href="tel:119" class="btn" style="background:rgba(239,68,68,0.15); color:#fca5a5; border:1px solid rgba(239,68,68,0.3);">
                            <i class="bi bi-telephone-fill me-2"></i>Hotline Kesehatan Jiwa: 119 ext 8
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
