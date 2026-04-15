@extends('layouts.app')
@section('title', 'Kuesioner — Domain ' . $category->name)

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-9">

            {{-- Progress Header --}}
            <div class="card-glass p-4 mb-4 animate-fadeup">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <div class="small text-muted mb-1">Langkah {{ $step }} dari {{ $totalSteps }}</div>
                        <h5 class="fw-bold mb-0">
                            <span class="badge me-2" style="background:rgba(99,102,241,0.2); color:#a5b4fc;">{{ $category->code }}</span>
                            {{ $category->name }}
                        </h5>
                    </div>
                    <div class="text-end">
                        <div class="fw-bold" style="color:#a5b4fc;">{{ round(($step - 1) / $totalSteps * 100) }}%</div>
                        <div class="small text-muted">Selesai</div>
                    </div>
                </div>

                {{-- Step Indicator --}}
                <div class="d-flex gap-2">
                    @foreach($categories as $i => $cat)
                        <div class="flex-grow-1 rounded-pill" style="height:5px; background: {{ ($i + 1) < $step ? 'var(--success)' : (($i + 1) == $step ? 'var(--primary)' : 'rgba(255,255,255,0.1)') }};"></div>
                    @endforeach
                </div>

                {{-- Deskripsi domain --}}
                @if($category->description)
                    <p class="text-muted small mb-0 mt-3">
                        <i class="bi bi-info-circle me-1" style="color:#67e8f9;"></i>
                        {{ $category->description }}
                    </p>
                @endif
            </div>

            {{-- Form Kuesioner --}}
            <form method="POST" action="{{ route('assessment.save', $step) }}" id="questionForm">
                @csrf
                @if($errors->any())
                    <div class="alert alert-danger mb-4">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        Harap pilih jawaban untuk <strong>semua pernyataan</strong> sebelum melanjutkan.
                    </div>
                @endif

                @foreach($category->symptoms as $idx => $symptom)
                    <div class="card-glass p-4 mb-3 animate-fadeup question-card" style="animation-delay:{{ $idx * 0.05 }}s;" id="q-{{ $symptom->id }}">
                        <div class="d-flex gap-3 mb-3">
                            <div class="flex-shrink-0 d-flex align-items-center justify-content-center rounded-circle fw-bold small"
                                 style="width:36px; height:36px; background:rgba(99,102,241,0.15); color:#a5b4fc; min-width:36px;">
                                {{ $symptom->code }}
                            </div>
                            <div>
                                <p class="mb-1 fw-medium" style="line-height:1.6;">{{ $symptom->statement }}</p>
                                @if($symptom->reference)
                                    <small class="text-muted" style="font-size:.72rem;">
                                        <i class="bi bi-journal-text me-1"></i>{{ $symptom->reference }}
                                    </small>
                                @endif
                                @if($symptom->is_critical)
                                    <span class="badge ms-2" style="background:rgba(239,68,68,0.15); color:#fca5a5; font-size:.68rem;">
                                        <i class="bi bi-exclamation-triangle me-1"></i>Indikator Kritis
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Likert Scale --}}
                        <div class="row g-2" role="group" aria-label="Skala untuk {{ $symptom->code }}">
                            @foreach($likertChoices as $val => $label)
                                <div class="col">
                                    <input
                                        type="radio"
                                        class="likert-option"
                                        name="answers[{{ $symptom->id }}]"
                                        id="s{{ $symptom->id }}_v{{ $val }}"
                                        value="{{ $val }}"
                                        {{ isset($existingAnswers[$symptom->id]) && $existingAnswers[$symptom->id] == $val ? 'checked' : '' }}
                                        required
                                    >
                                    <label class="likert-label w-100" for="s{{ $symptom->id }}_v{{ $val }}">
                                        <span class="likert-num">{{ $val }}</span>
                                        <span>{{ $label }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                {{-- Navigasi --}}
                <div class="d-flex justify-content-between align-items-center mt-4">
                    @if($step > 1)
                        <a href="{{ route('assessment.question', $step - 1) }}" class="btn btn-outline-qlc">
                            <i class="bi bi-arrow-left me-2"></i>Sebelumnya
                        </a>
                    @else
                        <a href="{{ route('assessment.intro') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Kembali
                        </a>
                    @endif

                    <button type="submit" class="btn btn-primary-qlc" id="submitBtn">
                        @if($step < $totalSteps)
                            Selanjutnya <i class="bi bi-arrow-right ms-2"></i>
                        @else
                            <i class="bi bi-cpu me-2"></i>Proses Hasil
                        @endif
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Highlight card saat jawaban dipilih
document.querySelectorAll('.likert-option').forEach(radio => {
    radio.addEventListener('change', function() {
        const card = this.closest('.question-card');
        card.style.borderColor = 'rgba(99,102,241,0.5)';
        card.style.background = 'rgba(99,102,241,0.06)';
    });
});

// Pre-apply style untuk jawaban yang sudah ada
document.querySelectorAll('.likert-option:checked').forEach(radio => {
    const card = radio.closest('.question-card');
    card.style.borderColor = 'rgba(99,102,241,0.5)';
    card.style.background = 'rgba(99,102,241,0.06)';
});

// Validasi sebelum submit
document.getElementById('questionForm').addEventListener('submit', function(e) {
    const cards = document.querySelectorAll('.question-card');
    let allAnswered = true;

    cards.forEach(card => {
        const radios = card.querySelectorAll('.likert-option');
        const answered = [...radios].some(r => r.checked);
        if (!answered) {
            card.style.borderColor = 'rgba(239,68,68,0.6)';
            card.style.background = 'rgba(239,68,68,0.06)';
            allAnswered = false;
        }
    });

    if (!allAnswered) {
        e.preventDefault();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
});
</script>
@endpush
