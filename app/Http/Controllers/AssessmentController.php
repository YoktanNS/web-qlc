<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\AssessmentAnswer;
use App\Models\AssessmentResult;
use App\Models\RecommendationResult;
use App\Models\SymptomCategory;
use App\Services\ForwardChainingService;
use App\Services\SAWService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AssessmentController extends Controller
{
    public function __construct(
        private ForwardChainingService $fcService,
        private SAWService $sawService
    ) {}

    /**
     * Halaman intro/landing sebelum kuesioner.
     */
    public function intro()
    {
        return view('assessment.intro');
    }

    /**
     * Mulai sesi asesmen baru.
     */
    public function start(Request $request)
    {
        // Jika sudah ada sesi aktif di session, hapus dulu
        session()->forget('assessment_id');

        // Buat assessment baru
        $assessment = Assessment::create([
            'user_id'     => Auth::id(),
            'guest_token' => Auth::check() ? null : Str::random(60),
            'status'      => 'in_progress',
            'started_at'  => now(),
        ]);

        // Simpan token guest di cookie jika tidak login
        if (!Auth::check()) {
            cookie()->queue('guest_token', $assessment->guest_token, 60 * 24);
        }

        session(['assessment_id' => $assessment->id]);

        return redirect()->route('assessment.question', ['step' => 1]);
    }

    /**
     * Tampilkan halaman pertanyaan per langkah (domain).
     * Setiap domain = satu halaman.
     */
    public function question(Request $request, int $step)
    {
        $categories = SymptomCategory::with(['symptoms' => fn ($q) => $q->where('is_active', true)->orderBy('order')])
            ->orderBy('order')
            ->get();

        $totalSteps = $categories->count();

        if ($step < 1 || $step > $totalSteps) {
            return redirect()->route('assessment.question', ['step' => 1]);
        }

        $category    = $categories[$step - 1];
        $assessmentId = session('assessment_id');

        if (!$assessmentId) {
            return redirect()->route('assessment.intro');
        }

        // Ambil jawaban yang sudah ada untuk pre-fill form
        $existingAnswers = AssessmentAnswer::where('assessment_id', $assessmentId)
            ->whereIn('symptom_id', $category->symptoms->pluck('id'))
            ->pluck('likert_score', 'symptom_id');

        $likertChoices = ForwardChainingService::getLikertChoices();

        return view('assessment.question', compact(
            'category', 'step', 'totalSteps', 'existingAnswers', 'likertChoices', 'categories'
        ));
    }

    /**
     * Simpan jawaban satu halaman/domain.
     */
    public function saveAnswers(Request $request, int $step)
    {
        $assessmentId = session('assessment_id');

        if (!$assessmentId) {
            return redirect()->route('assessment.intro');
        }

        $assessment = Assessment::findOrFail($assessmentId);

        // Validasi: semua symptom_id harus diisi
        $request->validate([
            'answers'   => 'required|array',
            'answers.*' => 'required|integer|min:1|max:5',
        ]);

        // Simpan atau update jawaban
        foreach ($request->answers as $symptomId => $likertScore) {
            $weighted = ForwardChainingService::likertToWeighted((int) $likertScore);

            AssessmentAnswer::updateOrCreate(
                ['assessment_id' => $assessment->id, 'symptom_id' => (int) $symptomId],
                ['likert_score' => (int) $likertScore, 'weighted_score' => $weighted]
            );
        }

        // Hitung total domain
        $totalSteps = SymptomCategory::count();

        if ($step >= $totalSteps) {
            // Langkah terakhir — proses hasil
            return $this->processResult($assessment);
        }

        return redirect()->route('assessment.question', ['step' => $step + 1]);
    }

    /**
     * Proses Forward Chaining + SAW dan simpan hasil.
     */
    private function processResult(Assessment $assessment)
    {
        // Reload dengan relasi lengkap
        $assessment->load('answers.symptom.category');

        // ── Forward Chaining ────────────────────────────────────────
        $fcResult = $this->fcService->process($assessment);

        $assessmentResult = AssessmentResult::create([
            'assessment_id'   => $assessment->id,
            'qlc_level_id'    => $fcResult['qlc_level']->id,
            'total_score'     => $fcResult['total_score'],
            'base_level_score'=> $fcResult['base_level_score'],
            'dominant_domain' => $fcResult['dominant_domain'],
            'domain_scores'   => $fcResult['domain_scores'],
            'fc_rules_fired'  => $fcResult['fc_rules_fired'],
        ]);

        // ── SAW (hanya jika level bukan severe) ─────────────────────
        if ($fcResult['qlc_level']->allow_action_plan) {
            $ranked = $this->sawService->rank($assessmentResult);

            foreach ($ranked as $item) {
                RecommendationResult::create([
                    'assessment_result_id' => $assessmentResult->id,
                    'action_plan_id'       => $item['action_plan']->id,
                    'saw_raw_score'        => $item['saw_raw_score'],
                    'saw_normalized_score' => $item['saw_normalized'],
                    'saw_final_score'      => $item['saw_final_score'],
                    'rank'                 => $item['rank'],
                ]);
            }
        }

        // Tandai asesmen selesai
        $assessment->update([
            'status'       => 'completed',
            'completed_at' => now(),
        ]);

        return redirect()->route('result.show', $assessmentResult->id);
    }
}
