@extends('layouts.app')
@section('title', 'Hasil SUS')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">

            {{-- Skor Utama --}}
            <div class="card-glass p-5 text-center mb-4 animate-fadeup">
                <h5 class="text-muted mb-3">Skor System Usability Scale (SUS)</h5>
                <div class="display-3 fw-bold mb-2" style="color:#67e8f9;">
                    {{ number_format($susAssessment->sus_score, 1) }}
                </div>
                <div class="fs-4 fw-bold mb-1">Grade: {{ $susAssessment->sus_grade }}</div>
                <div class="badge px-4 py-2 rounded-pill fs-6 mb-4"
                     style="background:rgba(6,182,212,0.2); color:#67e8f9;">
                    {{ $susAssessment->sus_adjective }}
                </div>

                {{-- Gauge Visual --}}
                <div class="mb-4">
                    <div class="progress" style="height:14px; background:rgba(255,255,255,0.08);">
                        <div class="progress-bar" style="width:{{ $susAssessment->sus_score }}%; background: linear-gradient(90deg, #ef4444, #f59e0b, #10b981); border-radius:99px;"></div>
                    </div>
                    <div class="d-flex justify-content-between small text-muted mt-1">
                        <span>0 — Awful</span><span>50 — Okay</span><span>100 — Excellent</span>
                    </div>
                </div>

                {{-- SUS Grading Table --}}
                <div class="text-start p-3 rounded-3 mb-4" style="background:rgba(255,255,255,0.04);">
                    <div class="small text-muted mb-2 fw-bold">Skala Penilaian SUS</div>
                    @php
                        $grades = [
                            ['range'=>'≥ 85','grade'=>'A','adj'=>'Excellent','color'=>'#10b981'],
                            ['range'=>'70–84','grade'=>'B','adj'=>'Good','color'=>'#06b6d4'],
                            ['range'=>'60–69','grade'=>'C','adj'=>'Okay','color'=>'#f59e0b'],
                            ['range'=>'50–59','grade'=>'D','adj'=>'Poor','color'=>'#f97316'],
                            ['range'=>'< 50', 'grade'=>'F','adj'=>'Awful','color'=>'#ef4444'],
                        ];
                    @endphp
                    <div class="row g-1">
                        @foreach($grades as $g)
                            <div class="col">
                                <div class="p-2 rounded-2 text-center" style="background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.06);">
                                    <div class="fw-bold" style="color:{{ $g['color'] }};">{{ $g['grade'] }}</div>
                                    <div class="small text-muted" style="font-size:.7rem;">{{ $g['adj'] }}</div>
                                    <div style="font-size:.68rem; color:{{ $g['color'] }};">{{ $g['range'] }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="d-flex gap-3 justify-content-center">
                    <a href="{{ route('home') }}" class="btn btn-outline-qlc">
                        <i class="bi bi-house me-2"></i>Beranda
                    </a>
                    <a href="{{ route('assessment.intro') }}" class="btn btn-primary-qlc">
                        <i class="bi bi-arrow-repeat me-2"></i>Tes QLC Lagi
                    </a>
                </div>
            </div>

            {{-- Jawaban Detail --}}
            <div class="card-glass p-4 animate-fadeup" style="animation-delay:.1s">
                <h6 class="fw-bold mb-3"><i class="bi bi-list-check me-2" style="color:#67e8f9;"></i>Detail Jawaban</h6>
                @foreach($questions as $num => $text)
                    @php $answer = $susAssessment->answers->firstWhere('question_number', $num); @endphp
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom border-secondary small">
                        <span class="text-muted pe-3">{{ $num }}. {{ $text }}</span>
                        <span class="fw-bold flex-shrink-0" style="color:#a5b4fc;">{{ $answer?->score ?? '-' }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
