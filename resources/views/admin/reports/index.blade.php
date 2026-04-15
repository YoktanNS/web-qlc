@extends('layouts.admin')
@section('title', 'Laporan Asesmen')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Laporan Asesmen</h4>
</div>

{{-- Filter --}}
<div class="card-glass p-3 mb-4">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-sm-3">
            <label class="form-label">Level QLC</label>
            <select name="level" class="form-select form-select-sm">
                <option value="">Semua Level</option>
                @foreach(['none'=>'Tidak Terdeteksi','mild'=>'Ringan','moderate'=>'Sedang','severe'=>'Berat'] as $c => $n)
                    <option value="{{ $c }}" {{ request('level') == $c ? 'selected' : '' }}>{{ $n }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-3">
            <label class="form-label">Dari Tanggal</label>
            <input type="date" name="date_from" class="form-control form-control-sm" value="{{ request('date_from') }}">
        </div>
        <div class="col-sm-3">
            <label class="form-label">Sampai Tanggal</label>
            <input type="date" name="date_to" class="form-control form-control-sm" value="{{ request('date_to') }}">
        </div>
        <div class="col-sm-3">
            <button type="submit" class="btn btn-primary-admin btn-sm w-100">
                <i class="bi bi-filter me-1"></i>Filter
            </button>
        </div>
    </form>
</div>

<div class="card-glass p-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-qlc mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Pengguna</th>
                    <th>Level QLC</th>
                    <th>Skor</th>
                    <th>Domain Dominan</th>
                    <th>Rule FC</th>
                    <th>Waktu</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($results as $r)
                    <tr>
                        <td class="text-muted small">{{ $r->id }}</td>
                        <td>
                            @if($r->assessment->user)
                                <div class="fw-medium">{{ $r->assessment->user->name }}</div>
                                <div class="small text-muted">{{ $r->assessment->user->email }}</div>
                            @else
                                <span class="text-muted small"><i class="bi bi-incognito me-1"></i>Tamu</span>
                            @endif
                        </td>
                        <td><span class="badge badge-level-{{ $r->qlcLevel->code }}">{{ $r->qlcLevel->name }}</span></td>
                        <td class="fw-bold">{{ $r->total_score }}/80</td>
                        <td class="small text-muted">{{ $r->dominant_domain }}</td>
                        <td>
                            @if($r->fc_rules_fired && count($r->fc_rules_fired) > 0)
                                @foreach($r->fc_rules_fired as $fc)
                                    <span class="badge me-1" style="background:rgba(6,182,212,0.15); color:#67e8f9; font-size:.7rem;">{{ $fc }}</span>
                                @endforeach
                            @else
                                <span class="text-muted small">—</span>
                            @endif
                        </td>
                        <td class="small text-muted">{{ $r->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.reports.show', $r->id) }}" class="btn btn-sm" style="background:rgba(99,102,241,0.15); color:#a5b4fc; font-size:.75rem;">
                                <i class="bi bi-eye me-1"></i>Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">Belum ada data asesmen.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $results->withQueryString()->links() }}</div>
@endsection
