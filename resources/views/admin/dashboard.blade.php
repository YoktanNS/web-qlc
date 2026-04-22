@extends('layouts.admin')
@section('title', 'Dashboard Admin')

@section('content')

<div class="page-header">
    <div>
        <h2><i class="bi bi-speedometer2 me-2" style="color: var(--primary);"></i>Dashboard</h2>
        <p class="page-sub">Ringkasan data sistem QLC Detector</p>
    </div>
    <span class="small" style="color: var(--text-muted); background: var(--cream-2); padding: .4rem .9rem; border-radius: 20px; border: 1px solid var(--card-border);">
        <i class="bi bi-calendar3 me-1" style="color: var(--primary);"></i>{{ now()->translatedFormat('d F Y') }}
    </span>
</div>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    @php
        $statCards = [
            ['label'=>'Total Pengguna',  'value'=>$stats['total_users'],       'icon'=>'bi-people',          'bg'=>'rgba(107,158,114,0.12)', 'color'=>'var(--primary-dark)'],
            ['label'=>'Total Asesmen',   'value'=>$stats['total_assessments'], 'icon'=>'bi-clipboard-check', 'bg'=>'rgba(181,144,106,0.13)', 'color'=>'var(--accent)'],
            ['label'=>'Evaluasi SUS',    'value'=>$stats['total_sus'],         'icon'=>'bi-star-half',       'bg'=>'rgba(168,122,40,0.12)',  'color'=>'var(--warning)'],
            ['label'=>'Rata-rata SUS',   'value'=>$stats['avg_sus_score'],     'icon'=>'bi-graph-up',        'bg'=>'rgba(78,143,85,0.12)',   'color'=>'var(--success)'],
        ];
    @endphp
    @foreach($statCards as $s)
        <div class="col-sm-6 col-xl-3">
            <div class="card-stat">
                <div class="d-flex justify-content-between align-items-start gap-2">
                    <div>
                        <div class="stat-label mb-2">{{ $s['label'] }}</div>
                        <div class="stat-value" style="color: {{ $s['color'] }};">{{ $s['value'] }}</div>
                    </div>
                    <div class="stat-icon" style="background: {{ $s['bg'] }};">
                        <i class="bi {{ $s['icon'] }}" style="color: {{ $s['color'] }};"></i>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="row g-3">
    {{-- Distribusi Level QLC --}}
    <div class="col-lg-5">
        <div class="card-glass h-100">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-pie-chart" style="color: var(--primary);"></i>
                <span>Distribusi Level QLC</span>
            </div>
            <div class="p-4">
                <canvas id="levelChart" height="200"></canvas>
                <div class="mt-3">
                    @foreach($levelDistribution as $d)
                        <div class="d-flex justify-content-between align-items-center py-2" style="border-bottom: 1px solid rgba(221,213,196,0.4);">
                            <span class="badge badge-level-{{ $d->code }}">{{ $d->name }}</span>
                            <span class="fw-bold" style="color: var(--text-main);">{{ $d->total }} <span class="fw-normal text-muted">asesmen</span></span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Asesmen Terbaru --}}
    <div class="col-lg-7">
        <div class="card-glass h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-clock-history me-2" style="color: var(--primary);"></i>Asesmen Terbaru</span>
                <a href="{{ route('admin.reports.index') }}" class="btn btn-sm btn-outline-secondary">
                    Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="p-0">
                <div class="table-responsive">
                    <table class="table table-qlc mb-0">
                        <thead>
                            <tr>
                                <th>Pengguna</th>
                                <th>Level</th>
                                <th>Skor</th>
                                <th>Waktu</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentAssessments as $a)
                                <tr>
                                    <td>
                                        @if($a->user)
                                            <span class="fw-semibold">{{ $a->user->name }}</span>
                                            <div class="small text-muted">{{ $a->user->email }}</div>
                                        @else
                                            <span class="text-muted small"><i class="bi bi-incognito me-1"></i>Tamu</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($a->result)
                                            <span class="badge badge-level-{{ $a->result->qlcLevel->code }}">{{ $a->result->qlcLevel->name }}</span>
                                        @else <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td class="fw-bold" style="color: var(--primary-dark);">{{ $a->result?->total_score ?? '—' }}</td>
                                    <td class="text-muted small">{{ $a->completed_at?->diffForHumans() }}</td>
                                    <td>
                                        @if($a->result)
                                            <a href="{{ route('admin.reports.show', $a->result->id) }}" class="btn btn-sm btn-outline-secondary" style="font-size:.73rem;">Detail</a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted py-4"><i class="bi bi-inbox me-2"></i>Belum ada data asesmen.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
const levelData = @json($levelDistribution);
new Chart(document.getElementById('levelChart').getContext('2d'), {
    type: 'doughnut',
    data: {
        labels: levelData.map(d => d.name),
        datasets: [{
            data: levelData.map(d => d.total),
            backgroundColor: ['#4e8f55','#b5906a','#a87a28','#a83a3a'],
            borderWidth: 3,
            borderColor: '#ffffff',
            hoverOffset: 8
        }]
    },
    options: {
        responsive: true,
        cutout: '68%',
        plugins: {
            legend: { display: false },
            tooltip: { callbacks: { label: ctx => ` ${ctx.raw} asesmen` } }
        }
    }
});
</script>
@endpush
