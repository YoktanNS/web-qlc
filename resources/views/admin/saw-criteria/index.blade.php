@extends('layouts.admin')
@section('title', 'Kriteria SAW')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold mb-0">Kriteria SAW</h4>
    <p class="text-muted small">Bobot total harus = 1.00 (100%)</p>
</div>

@if(abs($totalWeight - 1) > 0.01)
    <div class="alert alert-danger mb-4">
        <i class="bi bi-exclamation-triangle me-2"></i>
        <strong>Perhatian:</strong> Total bobot saat ini = <strong>{{ $totalWeight }}</strong>. Seharusnya = 1.00.
    </div>
@else
    <div class="alert alert-success mb-4">
        <i class="bi bi-check-circle me-2"></i>Total bobot = <strong>{{ $totalWeight }}</strong> ✓
    </div>
@endif

<div class="row g-3">
    @foreach($criteria as $c)
        <div class="col-md-6">
            <div class="card-glass p-4">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <span class="badge me-2" style="background:rgba(99,102,241,0.2); color:#a5b4fc;">{{ $c->code }}</span>
                        <span class="fw-bold">{{ $c->name }}</span>
                    </div>
                    <div class="d-flex gap-2 align-items-center">
                        <span class="badge" style="background:rgba(16,185,129,0.15); color:#6ee7b7;">{{ $c->type }}</span>
                        <a href="{{ route('admin.saw-criteria.edit', $c) }}" class="btn btn-sm" style="background:rgba(99,102,241,0.12); color:#a5b4fc; font-size:.72rem;"><i class="bi bi-pencil"></i></a>
                    </div>
                </div>
                <p class="text-muted small mb-2">{{ $c->description }}</p>
                <div class="d-flex align-items-center gap-3">
                    <div class="progress flex-grow-1" style="height:8px; background:rgba(255,255,255,0.08);">
                        <div class="progress-bar" style="width:{{ $c->weight * 100 }}%; background:#6366f1;"></div>
                    </div>
                    <span class="fw-bold" style="color:#a5b4fc; min-width:40px;">{{ ($c->weight * 100) }}%</span>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
