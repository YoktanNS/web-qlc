@extends('layouts.admin')
@section('title', 'Rule Forward Chaining')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold mb-0">Rule Forward Chaining</h4>
    <p class="text-muted small">Aturan eskalasi level QLC berdasarkan gejala kritis</p>
</div>
@foreach($rules as $rule)
    <div class="card-glass p-4 mb-3">
        <div class="d-flex justify-content-between align-items-start mb-2">
            <div class="d-flex gap-2 align-items-center">
                <span class="badge" style="background:rgba(6,182,212,0.15); color:#67e8f9;">{{ $rule->code }}</span>
                <span class="fw-bold">{{ $rule->name }}</span>
                <span class="badge" style="background:rgba(99,102,241,0.12); color:#a5b4fc; font-size:.7rem;">Prioritas {{ $rule->priority }}</span>
                @if(!$rule->is_active)<span class="badge" style="background:rgba(239,68,68,0.12); color:#fca5a5; font-size:.7rem;">Non-aktif</span>@endif
            </div>
            <a href="{{ route('admin.fc-rules.edit', $rule) }}" class="btn btn-sm" style="background:rgba(99,102,241,0.12); color:#a5b4fc; font-size:.78rem;"><i class="bi bi-pencil me-1"></i>Edit</a>
        </div>
        <p class="text-muted small mb-3">{{ $rule->description }}</p>
        <div class="row g-3">
            <div class="col-sm-6">
                <div class="small text-muted mb-1 fw-bold">IF (AND):</div>
                @foreach($rule->conditions as $cond)
                    <div class="small mb-1 p-2 rounded-2" style="background:rgba(255,255,255,0.04);">
                        @if($cond->condition_type === 'symptom_score')
                            <span style="color:#a5b4fc;">{{ $cond->symptom?->code }}</span> (weighted)
                            <strong>{{ $cond->operator }} {{ $cond->value }}</strong>
                        @elseif($cond->condition_type === 'total_score')
                            total_skor <strong>{{ $cond->operator }} {{ $cond->value }}</strong>
                        @elseif($cond->condition_type === 'critical_count')
                            jumlah_gejala_kritis_≥3 <strong>{{ $cond->operator }} {{ $cond->value }}</strong>
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="col-sm-6">
                <div class="small text-muted mb-1 fw-bold">THEN:</div>
                <div class="p-2 rounded-2" style="background:rgba(16,185,129,0.08);">
                    <span class="small">
                        <strong style="color:#6ee7b7;">{{ $rule->action_type }}</strong>
                        @if($rule->targetLevel) → <span class="badge badge-level-{{ $rule->targetLevel->code }}">{{ $rule->targetLevel->name }}</span>@endif
                    </span>
                </div>
            </div>
        </div>
    </div>
@endforeach
@endsection
