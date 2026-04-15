<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\SusAnswer;
use App\Models\SusAssessment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SUSController extends Controller
{
    // 10 pertanyaan standar SUS
    private const QUESTIONS = [
        1  => 'Saya pikir saya akan sering menggunakan sistem ini.',
        2  => 'Saya merasa sistem ini terlalu rumit untuk digunakan.',
        3  => 'Saya rasa sistem ini mudah digunakan.',
        4  => 'Saya membutuhkan bantuan teknis untuk menggunakan sistem ini.',
        5  => 'Saya menemukan bahwa berbagai fungsi dalam sistem ini sudah terintegrasi dengan baik.',
        6  => 'Saya rasa terlalu banyak ketidakkonsistenan dalam sistem ini.',
        7  => 'Saya bisa membayangkan orang lain akan dapat menggunakan sistem ini dengan sangat cepat.',
        8  => 'Saya merasa sistem ini sangat sulit untuk dioperasikan.',
        9  => 'Saya merasa sangat percaya diri menggunakan sistem ini.',
        10 => 'Saya perlu banyak belajar sebelum dapat menggunakan sistem ini dengan lancar.',
    ];

    /**
     * Tampilkan form kuesioner SUS.
     */
    public function form(Request $request)
    {
        // SUS dapat diisi independen atau setelah asesmen
        $assessmentResultId = $request->query('result_id');

        return view('sus.form', [
            'questions' => self::QUESTIONS,
            'assessmentResultId' => $assessmentResultId,
        ]);
    }

    /**
     * Simpan jawaban SUS dan hitung skor.
     */
    public function submit(Request $request)
    {
        $request->validate([
            'answers'   => 'required|array|size:10',
            'answers.*' => 'required|integer|min:1|max:5',
        ]);

        // Cari assessment terkait (opsional)
        $assessmentId = null;
        if ($request->assessment_result_id) {
            $result = \App\Models\AssessmentResult::find($request->assessment_result_id);
            $assessmentId = $result?->assessment_id;
        }

        // Buat SUS assessment
        $susAssessment = SusAssessment::create([
            'assessment_id' => $assessmentId,
            'user_id'       => Auth::id(),
            'guest_token'   => Auth::check() ? null : $request->cookie('guest_token'),
            'submitted_at'  => now(),
        ]);

        // Simpan jawaban
        foreach ($request->answers as $questionNo => $score) {
            SusAnswer::create([
                'sus_assessment_id' => $susAssessment->id,
                'question_number'   => (int) $questionNo,
                'score'             => (int) $score,
            ]);
        }

        // Hitung & simpan skor
        $susScore = $susAssessment->calculateScore();
        $gradeInfo = SusAssessment::getGrade($susScore);

        $susAssessment->update([
            'sus_score'     => $susScore,
            'sus_grade'     => $gradeInfo['grade'],
            'sus_adjective' => $gradeInfo['adjective'],
        ]);

        return redirect()->route('sus.result', $susAssessment->id);
    }

    /**
     * Tampilkan hasil skor SUS.
     */
    public function result(SusAssessment $susAssessment)
    {
        $susAssessment->load('answers');

        return view('sus.result', [
            'susAssessment' => $susAssessment,
            'questions'     => self::QUESTIONS,
        ]);
    }
}
