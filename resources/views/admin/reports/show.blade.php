@extends('layouts.admin')
@section('title', 'Detail Laporan Asesmen')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.reports.index') }}" class="small text-muted text-decoration-none"><i class="bi bi-arrow-left me-1"></i>Kembali ke Laporan</a>
    <h4 class="fw-bold mt-2 mb-0">Detail Hasil Asesmen #{{ $result->id }}</h4>
</div>

<div class="row g-3 mb-4">
    <div class="col-sm-3">
        <div class="card-stat text-center">
            <div class="fs-2 fw-bold" style="color:#a5b4fc;">{{ $result->total_score }}/80</div>
            <div class="small text-muted">Skor Total</div>
        </div>
    </div>
    <div class="col-sm-5">
        <div class="card-stat">
            <div class="small text-muted mb-1">Pengguna</div>
            @if($result->assessment->user)
                <div class="fw-bold">{{ $result->assessment->user->name }}</div>
                <div class="small text-muted">{{ $result->assessment->user->email }}</div>
            @else <div class="text-muted small">Tamu Anonim</div>@endif
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card-stat">
            <div class="small text-muted mb-1">Hasil Level</div>
            <span class="badge fs-6 badge-level-{{ $result->qlcLevel->code }}">{{ $result->qlcLevel->name }}</span>
            <div class="small text-muted mt-1">{{ $result->created_at->format('d/m/Y H:i') }}</div>
        </div>
    </div>
</div>

<div class="row g-3">
    {{-- Domain Scores --}}
    <div class="col-md-5">
        <div class="card-glass p-4 h-100">
            <h6 class="fw-bold mb-3">Skor per Domain</h6>
            @foreach($result->domain_scores ?? [] as $code => $d)
                @php $pct = $d['max']>0 ? round($d['score']/$d['max']*100) : 0; @endphp
                <div class="mb-2">
                    <div class="d-flex justify-content-between small mb-1">
                        <span><span class="badge" style="background:rgba(99,102,241,0.12); color:#a5b4fc; font-size:.68rem;">{{ $code }}</span> {{ $d['name'] }}</span>
                        <span class="fw-bold">{{ $d['score'] }}/{{ $d['max'] }}</span>
                    </div>
                    <div class="progress" style="height:6px; background:rgba(255,255,255,0.08); border-radius:99px;">
                        <div class="progress-bar" style="width:{{ $pct }}%; background:#6366f1; border-radius:99px;"></div>
                    </div>
                </div>
            @endforeach
            @if(count($result->fc_rules_fired ?? []) > 0)
                <div class="mt-3 pt-3 border-top border-secondary">
                    <div class="small text-muted mb-2">Rule FC Terpicu:</div>
                    @foreach($result->fc_rules_fired as $r)
                        <span class="badge me-1" style="background:rgba(6,182,212,0.15); color:#67e8f9;">{{ $r }}</span>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Rekomendasi SAW --}}
    <div class="col-md-7">
        <div class="card-glass p-4 h-100">
            <h6 class="fw-bold mb-3">Rekomendasi Action Plan (SAW)</h6>
            @forelse($result->recommendations as $rec)
                <div class="mb-2 p-2 rounded-2" style="background:rgba(255,255,255,0.03);">
                    <div class="d-flex gap-2 align-items-start">
                        <div class="d-flex align-items-center justify-content-center rounded-circle fw-bold mt-1" style="width:28px; height:28px; background:rgba(99,102,241,0.15); color:#a5b4fc; font-size:.8rem; flex-shrink:0;">{{ $rec->rank }}</div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="small fw-medium">{{ $rec->actionPlan->name }}</div>
                                <button class="btn btn-link py-0 px-1 text-decoration-none" style="font-size:.7rem; color:#a5b4fc;" data-bs-toggle="collapse" data-bs-target="#adminAp{{ $rec->id }}">Detail</button>
                            </div>
                            <div style="font-size:.72rem; color:#67e8f9;">SAW: {{ number_format($rec->saw_final_score, 4) }}</div>
                        </div>
                    </div>
                    <div class="collapse" id="adminAp{{ $rec->id }}">
                        <div class="mt-2 pt-2 border-top" style="border-color:rgba(255,255,255,0.05)!important;">
                            <div class="small text-muted mb-1">{{ $rec->actionPlan->description }}</div>
                            @if($rec->actionPlan->how_to)
                                <div class="small text-muted" style="white-space:pre-line; font-size:.7rem;"><strong>Cara:</strong><br>{{ $rec->actionPlan->how_to }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted small">Tidak ada rekomendasi (QLC Berat → rujuk psikolog).</p>
            @endforelse
        </div>
    </div>

    {{-- Jawaban Detail --}}
    <div class="col-12">
        <div class="card-glass p-4">
            <h6 class="fw-bold mb-3">Jawaban Kuesioner</h6>
            <div class="table-responsive">
                <table class="table table-qlc table-sm mb-0">
                    <thead><tr><th>Kode</th><th>Pernyataan</th><th>Kategori</th><th class="text-center">Likert</th><th class="text-center">Poin</th></tr></thead>
                    <tbody>
                        @foreach($result->assessment->answers->sortBy('symptom.order') as $ans)
                            <tr>
                                <td><span class="badge" style="background:rgba(255,255,255,0.07); color:#94a3b8;">{{ $ans->symptom->code }}</span></td>
                                <td class="small" style="max-width:350px;">{{ $ans->symptom->statement }}</td>
                                <td class="small text-muted">{{ $ans->symptom->category?->code }}</td>
                                <td class="text-center fw-bold" style="color:#a5b4fc;">{{ $ans->likert_score }}</td>
                                <td class="text-center fw-bold" style="color:#6ee7b7;">{{ $ans->weighted_score }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
