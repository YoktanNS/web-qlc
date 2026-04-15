<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Assessment;
use App\Models\AssessmentAnswer;
use App\Models\AssessmentResult;
use App\Models\RecommendationResult;
use App\Models\Symptom;
use App\Services\ForwardChainingService;
use App\Services\SAWService;

echo "=== TEST FORWARD CHAINING + SAW ===" . PHP_EOL . PHP_EOL;

// 1. Buat assessment test
$assessment = Assessment::create([
    'user_id'     => null,
    'guest_token' => 'test-token-verify-' . time(),
    'status'      => 'in_progress',
    'started_at'  => now(),
]);

// 2. Isi jawaban: Likert 3 (weighted 2) untuk semua gejala
$symptoms = Symptom::where('is_active', true)->get();
foreach ($symptoms as $s) {
    AssessmentAnswer::create([
        'assessment_id' => $assessment->id,
        'symptom_id'    => $s->id,
        'likert_score'  => 3,
        'weighted_score'=> 2,
    ]);
}

echo "✓ Assessment ID: {$assessment->id}" . PHP_EOL;
echo "✓ Jawaban diisi: {$symptoms->count()} gejala" . PHP_EOL . PHP_EOL;

// 3. Test FC
$fcService = app(ForwardChainingService::class);
$fcResult  = $fcService->process($assessment);

echo "=== HASIL FORWARD CHAINING ===" . PHP_EOL;
echo "Total Score    : {$fcResult['total_score']}/80" . PHP_EOL;
echo "Level          : {$fcResult['qlc_level']->name} ({$fcResult['qlc_level']->code})" . PHP_EOL;
echo "Dominant Domain: {$fcResult['dominant_domain']}" . PHP_EOL;
echo "FC Rules Fired : " . (empty($fcResult['fc_rules_fired']) ? '(none)' : implode(', ', $fcResult['fc_rules_fired'])) . PHP_EOL;
echo "Domain Scores  :" . PHP_EOL;
foreach ($fcResult['domain_scores'] as $code => $d) {
    $pct = $d['max'] > 0 ? round($d['score'] / $d['max'] * 100) : 0;
    echo "  {$code}: {$d['score']}/{$d['max']} ({$pct}%)" . PHP_EOL;
}

// 4. Simpan hasil
$assessmentResult = AssessmentResult::create([
    'assessment_id'    => $assessment->id,
    'qlc_level_id'     => $fcResult['qlc_level']->id,
    'total_score'      => $fcResult['total_score'],
    'base_level_score' => $fcResult['base_level_score'],
    'dominant_domain'  => $fcResult['dominant_domain'],
    'domain_scores'    => $fcResult['domain_scores'],
    'fc_rules_fired'   => $fcResult['fc_rules_fired'],
]);

// 5. Test SAW
echo PHP_EOL . "=== HASIL SAW RANKING ===" . PHP_EOL;
if ($fcResult['qlc_level']->allow_action_plan) {
    $sawService = app(SAWService::class);
    $ranked     = $sawService->rank($assessmentResult);

    foreach (array_slice($ranked, 0, 5) as $item) {
        $ap = $item['action_plan'];
        echo "  Rank {$item['rank']}: {$ap->name}" . PHP_EOL;
        echo "         SAW Final: {$item['saw_final_score']}" . PHP_EOL;
    }

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
} else {
    echo "  Level BERAT — tidak ada action plan, rujuk psikolog." . PHP_EOL;
}

$assessment->update(['status' => 'completed', 'completed_at' => now()]);

echo PHP_EOL . "✓ Test selesai! Assessment Result ID: {$assessmentResult->id}" . PHP_EOL;
echo "→ Akses hasil di: http://127.0.0.1:8000/hasil/{$assessmentResult->id}" . PHP_EOL;

// Cleanup
$assessmentResult->recommendations()->delete();
$assessmentResult->delete();
$assessment->answers()->delete();
$assessment->delete();

echo "✓ Data test dibersihkan." . PHP_EOL;
