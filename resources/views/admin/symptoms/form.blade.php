@extends('layouts.admin')
@section('title', isset($symptom) ? 'Edit Gejala' : 'Tambah Gejala')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.symptoms.index') }}" class="small text-muted text-decoration-none">
        <i class="bi bi-arrow-left me-1"></i>Kembali ke Daftar Gejala
    </a>
    <h4 class="fw-bold mt-2 mb-0">{{ isset($symptom) ? 'Edit Gejala' : 'Tambah Gejala Baru' }}</h4>
</div>

<div class="card-glass p-4" style="max-width:700px;">
    <form method="POST" action="{{ isset($symptom) ? route('admin.symptoms.update', $symptom) : route('admin.symptoms.store') }}">
        @csrf
        @if(isset($symptom)) @method('PUT') @endif

        @if($errors->any())
            <div class="alert alert-danger mb-3">
                @foreach($errors->all() as $e)<div>• {{ $e }}</div>@endforeach
            </div>
        @endif

        <div class="mb-3">
            <label class="form-label">Domain/Kategori *</label>
            <select name="symptom_category_id" class="form-select" required>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ (isset($symptom) && $symptom->symptom_category_id == $cat->id) || old('symptom_category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->code }} — {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="row g-3 mb-3">
            <div class="col-sm-3">
                <label class="form-label">Kode *</label>
                <input type="text" name="code" class="form-control" value="{{ old('code', $symptom->code ?? '') }}" placeholder="G21" maxlength="10" {{ isset($symptom) ? 'readonly' : '' }} required>
            </div>
            <div class="col-sm-3">
                <label class="form-label">Urutan *</label>
                <input type="number" name="order" class="form-control" value="{{ old('order', $symptom->order ?? 21) }}" required>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Pernyataan Gejala *</label>
            <textarea name="statement" class="form-control" rows="3" required>{{ old('statement', $symptom->statement ?? '') }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Referensi Literatur</label>
            <input type="text" name="reference" class="form-control" value="{{ old('reference', $symptom->reference ?? '') }}" placeholder="Nama penulis (tahun)">
        </div>
        <div class="mb-4 d-flex gap-4">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="is_critical" id="is_critical" value="1" {{ (isset($symptom) && $symptom->is_critical) || old('is_critical') ? 'checked' : '' }}>
                <label class="form-check-label small" for="is_critical">Gejala Kritis (G17-G20)</label>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ !isset($symptom) || $symptom->is_active ? 'checked' : '' }}>
                <label class="form-check-label small" for="is_active">Aktif</label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary-admin">
            <i class="bi bi-check-lg me-2"></i>{{ isset($symptom) ? 'Update' : 'Simpan' }}
        </button>
    </form>
</div>
@endsection
