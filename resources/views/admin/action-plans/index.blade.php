@extends('layouts.admin')
@section('title', 'Action Plan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Action Plan</h4>
    <a href="{{ route('admin.action-plans.create') }}" class="btn btn-primary-admin btn-sm">
        <i class="bi bi-plus-circle me-1"></i>Tambah Action Plan
    </a>
</div>

<div class="card-glass p-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-qlc mb-0">
            <thead>
                <tr><th>Kode</th><th>Nama</th><th>Kategori</th><th>Tingkat</th>
                    @foreach($criteria as $c)<th class="text-center small">{{ $c->code }}</th>@endforeach
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($actionPlans as $ap)
                    @php $scoreMap = $ap->criteriaScores->keyBy('saw_criteria_id'); @endphp
                    <tr>
                        <td><span class="badge" style="background:rgba(255,255,255,0.07); color:#94a3b8;">{{ $ap->code }}</span></td>
                        <td>
                            <div class="fw-medium small">{{ $ap->name }}</div>
                            <div class="text-muted" style="font-size:.72rem;">
                                {{ Str::limit($ap->description, 50) }}
                                <button type="button" class="btn btn-link btn-sm p-0 ms-1 text-decoration-none" style="font-size:.72rem; color:#a5b4fc;" data-bs-toggle="modal" data-bs-target="#modalAP{{ $ap->id }}">
                                    Selengkapnya
                                </button>
                            </div>
                        </td>
                        <td>
                            <span class="badge" style="background:rgba(99,102,241,0.12); color:#a5b4fc; font-size:.72rem;">{{ $ap->category }}</span>
                        </td>
                        <td class="small">{{ $ap->difficulty_label }}</td>
                        @foreach($criteria as $c)
                            <td class="text-center">
                                <span class="fw-bold" style="color:#{{ $scoreMap[$c->id]?->score >= 4 ? '10b981' : ($scoreMap[$c->id]?->score >= 3 ? '06b6d4' : 'f59e0b') }};">
                                    {{ $scoreMap[$c->id]?->score ?? '—' }}
                                </span>
                            </td>
                        @endforeach
                        <td class="text-end">
                            <a href="{{ route('admin.action-plans.edit', $ap) }}" class="btn btn-sm me-1" style="background:rgba(99,102,241,0.12); color:#a5b4fc; font-size:.72rem;"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('admin.action-plans.destroy', $ap) }}" class="d-inline" onsubmit="return confirm('Hapus action plan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm" style="background:rgba(239,68,68,0.12); color:#fca5a5; font-size:.72rem;"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3 p-3 rounded-3 small text-muted" style="background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.06);">
    <i class="bi bi-info-circle me-1"></i>Kolom C1-C4 menunjukkan nilai action plan pada setiap kriteria SAW (skala 1-5). Bobot: C1=35%, C2=25%, C3=25%, C4=15%.
</div>

{{-- Modals for Action Plan Details --}}
@foreach($actionPlans as $ap)
<div class="modal fade" id="modalAP{{ $ap->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background:var(--dark-2); border:1px solid var(--glass-border);">
            <div class="modal-header border-bottom-0 pb-0">
                <h6 class="modal-title fw-bold" style="color:#f1f5f9;">{{ $ap->name }}</h6>
                <button type="button" class="btn-close" style="filter:invert(1) opacity(0.5);" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <span class="badge" style="background:rgba(99,102,241,0.12); color:#a5b4fc; font-size:.72rem;">{{ $ap->category_label }}</span>
                    @if($ap->duration_minutes)
                        <span class="badge ms-1" style="background:rgba(255,255,255,0.1); color:#cbd5e1; font-size:.72rem;"><i class="bi bi-clock me-1"></i>{{ $ap->duration_minutes }} menit</span>
                    @endif
                </div>
                <h6 class="small fw-bold text-muted mb-1">Deskripsi Singkat</h6>
                <p class="small" style="color:#cbd5e1; line-height:1.6;">{{ $ap->description }}</p>

                @if($ap->how_to)
                <h6 class="small fw-bold text-muted mb-1 mt-3">Cara Melakukan</h6>
                <div class="p-3 rounded-3 small" style="background:rgba(255,255,255,0.03); color:#cbd5e1; white-space:pre-line; line-height:1.6;">{{ $ap->how_to }}</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection
