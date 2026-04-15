@extends('layouts.admin')
@section('title', 'Edit Kriteria SAW')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.saw-criteria.index') }}" class="small text-muted text-decoration-none"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
    <h4 class="fw-bold mt-2 mb-0">Edit Kriteria: {{ $sawCriteria->code }}</h4>
</div>
<div class="card-glass p-4" style="max-width:550px;">
    <form method="POST" action="{{ route('admin.saw-criteria.update', $sawCriteria) }}">
        @csrf @method('PUT')
        @if($errors->any())<div class="alert alert-danger mb-3">@foreach($errors->all() as $e)<div>• {{ $e }}</div>@endforeach</div>@endif
        <div class="mb-3"><label class="form-label">Nama Kriteria *</label><input type="text" name="name" class="form-control" value="{{ old('name', $sawCriteria->name) }}" required></div>
        <div class="mb-3"><label class="form-label">Deskripsi</label><textarea name="description" class="form-control" rows="2">{{ old('description', $sawCriteria->description) }}</textarea></div>
        <div class="row g-3 mb-3">
            <div class="col-sm-4"><label class="form-label">Bobot (0.01–1.0) *</label><input type="number" name="weight" class="form-control" value="{{ old('weight', $sawCriteria->weight) }}" step="0.01" min="0.01" max="1" required></div>
            <div class="col-sm-4"><label class="form-label">Tipe *</label>
                <select name="type" class="form-select" required>
                    <option value="benefit" {{ $sawCriteria->type === 'benefit' ? 'selected' : '' }}>Benefit</option>
                    <option value="cost"    {{ $sawCriteria->type === 'cost'    ? 'selected' : '' }}>Cost</option>
                </select>
            </div>
            <div class="col-sm-4"><label class="form-label">Urutan</label><input type="number" name="order" class="form-control" value="{{ old('order', $sawCriteria->order) }}"></div>
        </div>
        <button type="submit" class="btn btn-primary-admin"><i class="bi bi-check-lg me-2"></i>Update</button>
    </form>
</div>
@endsection
