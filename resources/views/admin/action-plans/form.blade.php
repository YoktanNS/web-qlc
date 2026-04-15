@extends('layouts.admin')
@section('title', isset($actionPlan) ? 'Edit Action Plan' : 'Tambah Action Plan')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.action-plans.index') }}" class="small text-muted text-decoration-none">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
    <h4 class="fw-bold mt-2 mb-0">{{ isset($actionPlan) ? 'Edit Action Plan' : 'Tambah Action Plan' }}</h4>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card-glass p-4">
            <form method="POST" action="{{ isset($actionPlan) ? route('admin.action-plans.update', $actionPlan) : route('admin.action-plans.store') }}">
                @csrf
                @if(isset($actionPlan)) @method('PUT') @endif

                @if($errors->any())
                    <div class="alert alert-danger mb-3">
                        @foreach($errors->all() as $e)<div>• {{ $e }}</div>@endforeach
                    </div>
                @endif

                <div class="row g-3 mb-3">
                    <div class="col-sm-3">
                        <label class="form-label">Kode *</label>
                        <input type="text" name="code" class="form-control" value="{{ old('code', $actionPlan->code ?? '') }}" maxlength="10" {{ isset($actionPlan) ? 'readonly' : '' }} required>
                    </div>
                    <div class="col-sm-5">
                        <label class="form-label">Kategori *</label>
                        <select name="category" class="form-select" required>
                            @foreach(['cognitive'=>'Kognitif (CBT)','journaling'=>'Journaling','behavioral'=>'Perilaku','mindfulness'=>'Mindfulness','social'=>'Sosial'] as $v => $l)
                                <option value="{{ $v }}" {{ old('category', $actionPlan->category ?? '') == $v ? 'selected' : '' }}>{{ $l }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label class="form-label">Tingkat Kesulitan *</label>
                        <select name="difficulty" class="form-select" required>
                            @foreach(['easy'=>'Mudah','medium'=>'Sedang','hard'=>'Sulit'] as $v => $l)
                                <option value="{{ $v }}" {{ old('difficulty', $actionPlan->difficulty ?? 'easy') == $v ? 'selected' : '' }}>{{ $l }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Action Plan *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $actionPlan->name ?? '') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi *</label>
                    <textarea name="description" class="form-control" rows="3" required>{{ old('description', $actionPlan->description ?? '') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Langkah-langkah (How To)</label>
                    <textarea name="how_to" class="form-control" rows="6" placeholder="Tuliskan langkah-langkah detail...">{{ old('how_to', $actionPlan->how_to ?? '') }}</textarea>
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-sm-4">
                        <label class="form-label">Durasi (menit)</label>
                        <input type="number" name="duration_minutes" class="form-control" value="{{ old('duration_minutes', $actionPlan->duration_minutes ?? '') }}">
                    </div>
                    <div class="col-sm-8">
                        <label class="form-label">Sumber Referensi</label>
                        <input type="text" name="source_reference" class="form-control" value="{{ old('source_reference', $actionPlan->source_reference ?? '') }}">
                    </div>
                </div>

                {{-- Bobot SAW --}}
                <h6 class="fw-bold mb-3"><i class="bi bi-sliders me-2" style="color:#67e8f9;"></i>Nilai Matriks SAW (1–5)</h6>
                <div class="row g-3 mb-4">
                    @foreach($criteria as $c)
                        <div class="col-sm-6">
                            <label class="form-label">{{ $c->code }}: {{ $c->name }}</label>
                            <div class="d-flex gap-2 align-items-center">
                                <input type="range" name="scores[{{ $c->id }}]" min="1" max="5" step="1"
                                       value="{{ old("scores.{$c->id}", isset($scoreMap) ? ($scoreMap[$c->id]?->score ?? 3) : 3) }}"
                                       class="form-range flex-grow-1"
                                       oninput="document.getElementById('sv{{ $c->id }}').textContent=this.value">
                                <span class="fw-bold" id="sv{{ $c->id }}" style="color:#a5b4fc; width:20px;">{{ isset($scoreMap) ? ($scoreMap[$c->id]?->score ?? 3) : 3 }}</span>
                            </div>
                            <small class="text-muted" style="font-size:.72rem;">{{ $c->description }}</small>
                        </div>
                    @endforeach
                </div>

                <div class="form-check form-switch mb-4">
                    <input type="checkbox" class="form-check-input" name="is_active" id="is_active" value="1" {{ !isset($actionPlan) || $actionPlan->is_active ? 'checked' : '' }}>
                    <label class="form-check-label small" for="is_active">Aktif (tampil dalam rekomendasi)</label>
                </div>

                <button type="submit" class="btn btn-primary-admin">
                    <i class="bi bi-check-lg me-2"></i>{{ isset($actionPlan) ? 'Update' : 'Simpan' }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
