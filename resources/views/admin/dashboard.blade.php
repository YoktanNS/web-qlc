@extends('layouts.admin')
@section('title', 'Dashboard Admin')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Dashboard</h4>
        <p class="text-muted small mb-0">Ringkasan data sistem QLC Detector</p>
    </div>
    <span class="small text-muted"><i class="bi bi-clock me-1"></i>{{ now()->translatedFormat('d F Y') }}</span>
</div>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    @php
        $statCards = [
            ['label'=>'Total Pengguna', 'value'=>$stats['total_users'],       'icon'=>'bi-people',         'color'=>'#6366f1'],
            ['label'=>'Total Asesmen',  'value'=>$stats['total_assessments'], 'icon'=>'bi-clipboard-check','color'=>'#8b5cf6'],
            ['label'=>'Evaluasi SUS',   'value'=>$stats['total_sus'],         'icon'=>'bi-star-half',      'color'=>'#06b6d4'],
            ['label'=>'Rata-rata SUS',  'value'=>$stats['avg_sus_score'],     'icon'=>'bi-graph-up',       'color'=>'#10b981'],
        ];
    @endphp
    @foreach($statCards as $s)
        <div class="col-sm-6 col-xl-3">
            <div class="card-stat">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="small text-muted mb-1">{{ $s['label'] }}</div>
                        <div class="fs-3 fw-bold" style="color:{{ $s['color'] }};">{{ $s['value'] }}</div>
                    </div>
                    <div class="d-flex align-items-center justify-content-center rounded-3" style="width:44px; height:44px; background:rgba(99,102,241,0.1);">
                        <i class="{{ $s['icon'] }}" style="color:{{ $s['color'] }};"></i>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="row g-3">
    {{-- Distribusi Level QLC --}}
    <div class="col-lg-5">
        <div class="card-glass p-4 h-100">
            <h6 class="fw-bold mb-4"><i class="bi bi-pie-chart me-2" style="color:#a5b4fc;"></i>Distribusi Level QLC</h6>
            <canvas id="levelChart" height="220"></canvas>
            <div class="mt-3">
                @foreach($levelDistribution as $d)
                    <div class="d-flex justify-content-between align-items-center py-1">
                        <span class="small"><span class="badge badge-level-{{ $d->code }} me-2">{{ $d->name }}</span></span>
                        <span class="small fw-bold">{{ $d->total }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Asesmen Terbaru --}}
    <div class="col-lg-7">
        <div class="card-glass p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0"><i class="bi bi-clock-history me-2" style="color:#67e8f9;"></i>Asesmen Terbaru</h6>
                <a href="{{ route('admin.reports.index') }}" class="btn btn-sm" style="background:rgba(99,102,241,0.15); color:#a5b4fc; font-size:.78rem;">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="table table-qlc table-sm mb-0">
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
                                        <span class="fw-medium">{{ $a->user->name }}</span>
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
                                <td class="fw-bold">{{ $a->result?->total_score ?? '—' }}</td>
                                <td class="text-muted small">{{ $a->completed_at?->diffForHumans() }}</td>
                                <td>
                                    @if($a->result)
                                        <a href="{{ route('admin.reports.show', $a->result->id) }}" class="btn btn-sm" style="background:rgba(255,255,255,0.06); color:#94a3b8; font-size:.72rem;">Detail</a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted py-3">Belum ada data asesmen.</td></tr>
                        @endforelse
                    </tbody>
                </table>
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
            backgroundColor: ['#10b981','#06b6d4','#f59e0b','#ef4444'],
            borderWidth: 0,
            hoverOffset: 6
        }]
    },
    options: {
        responsive: true,
        cutout: '65%',
        plugins: {
            legend: { display: false },
            tooltip: { callbacks: { label: ctx => ` ${ctx.raw} asesmen` } }
        }
    }
});
</script>
@endpush
