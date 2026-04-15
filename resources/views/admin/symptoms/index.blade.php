@extends('layouts.admin')
@section('title', 'Data Gejala QLC')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Data Gejala QLC</h4>
    <a href="{{ route('admin.symptoms.create') }}" class="btn btn-primary-admin btn-sm">
        <i class="bi bi-plus-circle me-1"></i>Tambah Gejala
    </a>
</div>

@foreach($categories as $cat)
    <div class="card-glass mb-3">
        <div class="p-3 d-flex justify-content-between align-items-center" style="border-bottom:1px solid rgba(255,255,255,0.07);">
            <div>
                <span class="badge me-2" style="background:rgba(99,102,241,0.2); color:#a5b4fc;">{{ $cat->code }}</span>
                <span class="fw-bold">{{ $cat->name }}</span>
                <span class="text-muted small ms-2">({{ $cat->symptoms->count() }} gejala)</span>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-qlc table-sm mb-0">
                <thead><tr><th>Kode</th><th>Pernyataan</th><th>Kritis</th><th>Ref</th><th></th></tr></thead>
                <tbody>
                    @foreach($cat->symptoms as $s)
                        <tr>
                            <td><span class="badge" style="background:rgba(255,255,255,0.08); color:#94a3b8;">{{ $s->code }}</span></td>
                            <td style="max-width:400px;">
                                <span class="small">{{ $s->statement }}</span>
                            </td>
                            <td>
                                @if($s->is_critical)
                                    <span class="badge" style="background:rgba(239,68,68,0.15); color:#fca5a5;">Kritis</span>
                                @else <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td class="small text-muted" style="max-width:200px; font-size:.72rem;">{{ $s->reference }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.symptoms.edit', $s) }}" class="btn btn-sm me-1" style="background:rgba(99,102,241,0.12); color:#a5b4fc; font-size:.72rem;">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.symptoms.destroy', $s) }}" class="d-inline" onsubmit="return confirm('Hapus gejala ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm" style="background:rgba(239,68,68,0.12); color:#fca5a5; font-size:.72rem;">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endforeach
@endsection
