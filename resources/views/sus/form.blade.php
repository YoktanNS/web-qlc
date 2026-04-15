@extends('layouts.app')
@section('title', 'Kuesioner SUS')

@push('styles')
<style>
    /* Semua kotak SUS Likert sama tingginya */
    .sus-scale .likert-label {
        min-height: 90px;
        justify-content: center;
        gap: .5rem;
    }
    .sus-scale .likert-label span:last-child {
        min-height: 2.4em;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        line-height: 1.3;
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-5 animate-fadeup">
                <div class="d-inline-flex align-items-center justify-content-center rounded-4 mb-3" style="width:72px; height:72px; background:rgba(6,182,212,0.15);">
                    <i class="bi bi-star-half fs-2" style="color:#67e8f9;"></i>
                </div>
                <h1 class="h3 fw-bold mb-2">Kuesioner Evaluasi Usabilitas</h1>
                <p class="text-muted">System Usability Scale (SUS) — Standar John Brooke (1996)</p>
            </div>

            <div class="card-glass p-4 mb-4 animate-fadeup">
                <div class="alert alert-info d-flex gap-2 mb-0">
                    <i class="bi bi-info-circle-fill flex-shrink-0"></i>
                    <span>Pilih angka <strong>1 (Sangat Tidak Setuju)</strong> hingga <strong>5 (Sangat Setuju)</strong> untuk setiap pernyataan berdasarkan pengalaman menggunakan sistem ini.</span>
                </div>
            </div>

            <form method="POST" action="{{ route('sus.submit') }}">
                @csrf
                @if($assessmentResultId)
                    <input type="hidden" name="assessment_result_id" value="{{ $assessmentResultId }}">
                @endif

                @if($errors->any())
                    <div class="alert alert-danger mb-4">Harap jawab semua pernyataan.</div>
                @endif

                @foreach($questions as $num => $text)
                    <div class="card-glass p-4 mb-3 animate-fadeup" style="animation-delay:{{ ($num-1) * 0.04 }}s">
                        <div class="d-flex gap-3 mb-3">
                            <div class="flex-shrink-0 d-flex align-items-center justify-content-center rounded-circle fw-bold"
                                 style="width:34px; height:34px; background:rgba(6,182,212,0.15); color:#67e8f9; min-width:34px; font-size:.9rem;">
                                {{ $num }}
                            </div>
                            <p class="mb-0 fw-medium" style="line-height:1.6;">{{ $text }}</p>
                        </div>

                        <div class="row g-2 sus-scale">
                            @foreach([
                                1 => 'Sangat<br>Tidak Setuju',
                                2 => 'Tidak<br>Setuju',
                                3 => 'Netral<br>&nbsp;',
                                4 => 'Setuju<br>&nbsp;',
                                5 => 'Sangat<br>Setuju'
                            ] as $val => $lbl)
                                <div class="col d-flex">
                                    <input type="radio" class="likert-option" name="answers[{{ $num }}]" id="sus_{{ $num }}_{{ $val }}" value="{{ $val }}" required>
                                    <label class="likert-label w-100" for="sus_{{ $num }}_{{ $val }}">
                                        <span class="likert-num">{{ $val }}</span>
                                        <span>{!! $lbl !!}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary-qlc w-100 btn-lg">
                        <i class="bi bi-send me-2"></i>Submit Evaluasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
