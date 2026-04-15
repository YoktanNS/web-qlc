<?php

namespace Database\Seeders;

use App\Models\FcRule;
use App\Models\FcRuleCondition;
use App\Models\QlcLevel;
use App\Models\Symptom;
use Illuminate\Database\Seeder;

class FcRuleSeeder extends Seeder
{
    public function run(): void
    {
        $moderate = QlcLevel::where('code', 'moderate')->first();
        $severe   = QlcLevel::where('code', 'severe')->first();

        $g17 = Symptom::where('code', 'G17')->first();
        $g18 = Symptom::where('code', 'G18')->first();
        $g19 = Symptom::where('code', 'G19')->first();
        $g20 = Symptom::where('code', 'G20')->first();

        /**
         * R1 — Eskalasi ke Sedang karena Hopelessness kritis
         * IF G20 (hopelessness) >= 3 (Sering) AND total_score >= 20
         * THEN set_minimum = "QLC Sedang"
         */
        $r1 = FcRule::updateOrCreate(['code' => 'R1'], [
            'name'            => 'Eskalasi Hopelessness ke Level Sedang',
            'description'     => 'Jika pengguna sering/selalu merasa putus asa DAN skor total sudah >= 20, level minimum dinaikkan ke QLC Sedang.',
            'priority'        => 10,
            'target_level_id' => $moderate?->id,
            'action_type'     => 'set_minimum',
            'is_active'       => true,
        ]);
        FcRuleCondition::updateOrCreate(
            ['fc_rule_id' => $r1->id, 'symptom_id' => $g20?->id, 'condition_type' => 'symptom_score'],
            ['operator' => '>=', 'value' => 3]
        );
        FcRuleCondition::updateOrCreate(
            ['fc_rule_id' => $r1->id, 'symptom_id' => null, 'condition_type' => 'total_score'],
            ['operator' => '>=', 'value' => 20]
        );

        /**
         * R2 — Eskalasi langsung ke Berat karena Hopelessness + Kecemasan parah
         * IF G20 = 4 (Selalu) AND G17 >= 3 (Sering) AND total_score >= 40
         * THEN set_level = "QLC Berat"
         */
        $r2 = FcRule::updateOrCreate(['code' => 'R2'], [
            'name'            => 'Eskalasi Langsung ke Berat (Hopelessness + Kecemasan)',
            'description'     => 'Jika pengguna selalu merasa putus asa DAN sering cemas DAN skor total >= 40, langsung ditetapkan ke QLC Berat.',
            'priority'        => 5,
            'target_level_id' => $severe?->id,
            'action_type'     => 'set_level',
            'is_active'       => true,
        ]);
        FcRuleCondition::updateOrCreate(
            ['fc_rule_id' => $r2->id, 'symptom_id' => $g20?->id, 'condition_type' => 'symptom_score'],
            ['operator' => '>=', 'value' => 4]
        );
        FcRuleCondition::updateOrCreate(
            ['fc_rule_id' => $r2->id, 'symptom_id' => $g17?->id, 'condition_type' => 'symptom_score'],
            ['operator' => '>=', 'value' => 3]
        );
        FcRuleCondition::updateOrCreate(
            ['fc_rule_id' => $r2->id, 'symptom_id' => null, 'condition_type' => 'total_score'],
            ['operator' => '>=', 'value' => 40]
        );

        /**
         * R3 — Eskalasi satu tingkat karena banyak gejala kritis
         * IF COUNT(G17, G18, G19, G20 dengan weighted_score >= 3) >= 3
         * THEN escalate_one (naik satu tingkat)
         */
        $r3 = FcRule::updateOrCreate(['code' => 'R3'], [
            'name'            => 'Eskalasi Satu Tingkat karena Multi-Gejala Kritis',
            'description'     => 'Jika >= 3 dari 4 gejala psikologis kritis (G17-G20) bernilai Sering/Selalu (>= 3 poin), level naik satu tingkat.',
            'priority'        => 15,
            'target_level_id' => null,
            'action_type'     => 'escalate_one',
            'is_active'       => true,
        ]);
        // Kondisi: jumlah gejala kritis dengan skor >= 3 adalah >= 3
        FcRuleCondition::updateOrCreate(
            ['fc_rule_id' => $r3->id, 'symptom_id' => null, 'condition_type' => 'critical_count'],
            ['operator' => '>=', 'value' => 3]
        );
    }
}
