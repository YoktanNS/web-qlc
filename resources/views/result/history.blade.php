@extends('layouts.app')
@section('title', 'Riwayat Asesmen')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1">Riwayat Asesmen</h2>
                    <p class="text-muted mb-0">Pantau perkembangan kondisimu dari waktu ke waktu</p>
                </div>
                <a href="{{ route('assessment.intro') }}" class="btn btn-primary-qlc">
                    <i class="bi bi-plus-circle me-2"></i>Tes Baru
                </a>
            </div>

            @forelse($assessments as $assessment)
                @php $res = $assessment->result; @endphp
                <div class="card-glass p-4 mb-3 animate-fadeup">
                    <div class="d-flex justify-content-between align-items-start gap-3">
                        <div class="flex-grow-1">
                            <div class="d-flex flex-wrap gap-2 align-items-center mb-2">
                                @if($res)
                                    <span class="badge px-3 py-2 level-badge-{{ $res->qlcLevel->code }}">
                                        <i class="{{ $res->qlcLevel->icon }} me-1"></i>{{ $res->qlcLevel->name }}
                                    </span>
                                @endif
                                <span class="text-muted small">
                                    <i class="bi bi-calendar3 me-1"></i>{{ $assessment->completed_at?->translatedFormat('d F Y, H:i') }}
                                </span>
                            </div>
                            @if($res)
                                <div class="d-flex gap-4">
                                    <div>
                                        <div class="small text-muted">Skor Total</div>
                                        <div class="fw-bold fs-5">{{ $res->total_score }}/80</div>
                                    </div>
                                    <div>
                                        <div class="small text-muted">Domain Dominan</div>
                                        <div class="fw-medium small">{{ $res->dominant_domain }}</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        @if($res)
                            <a href="{{ route('result.show', $res->id) }}" class="btn btn-outline-qlc btn-sm flex-shrink-0">
                                <i class="bi bi-eye me-1"></i>Lihat Detail
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="card-glass p-5 text-center">
                    <i class="bi bi-clipboard-x fs-1 mb-3 d-block text-muted"></i>
                    <h5 class="fw-bold">Belum Ada Riwayat</h5>
                    <p class="text-muted mb-4">Kamu belum pernah mengisi kuesioner QLC.</p>
                    <a href="{{ route('assessment.intro') }}" class="btn btn-primary-qlc">Mulai Tes Pertama</a>
                </div>
            @endforelse

            {{ $assessments->links() }}
        </div>
    </div>
</div>
@endsection
