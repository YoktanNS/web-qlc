<?php

namespace Database\Seeders;

use App\Models\Symptom;
use App\Models\SymptomCategory;
use Illuminate\Database\Seeder;

class SymptomSeeder extends Seeder
{
    public function run(): void
    {
        $symptoms = [
            // ── DOMAIN 1: Kebingungan Identitas Diri ──────────────────────────
            [
                'category_code' => 'D1',
                'code'         => 'G01',
                'statement'    => 'Saya merasa bingung tentang siapa diri saya sebenarnya dan apa yang benar-benar saya inginkan dalam hidup.',
                'reference'    => 'Robbins & Wilner (2001); Petrov, Robinson & Arnett (2022) — DCQ-12',
                'is_critical'  => false,
                'order'        => 1,
            ],
            [
                'category_code' => 'D1',
                'code'         => 'G02',
                'statement'    => 'Saya sering membandingkan pencapaian hidup saya dengan teman-teman sebaya dan merasa jauh tertinggal.',
                'reference'    => 'Robbins & Wilner (2001); Studi QLC Indonesia (ResearchGate, 2023)',
                'is_critical'  => false,
                'order'        => 2,
            ],
            [
                'category_code' => 'D1',
                'code'         => 'G03',
                'statement'    => 'Saya merasa hidup saya tidak memiliki arah atau tujuan yang jelas.',
                'reference'    => 'Petrov, Robinson & Arnett (2022) — DCQ-12 subskala "Disconnection & Distress"',
                'is_critical'  => false,
                'order'        => 3,
            ],
            [
                'category_code' => 'D1',
                'code'         => 'G04',
                'statement'    => 'Nilai-nilai dan prinsip hidup saya terasa tidak stabil atau terus berubah sehingga saya sulit membuat keputusan.',
                'reference'    => 'Atwood & Scholtz (2008); Petrov, Robinson & Arnett (2022)',
                'is_critical'  => false,
                'order'        => 4,
            ],

            // ── DOMAIN 2: Krisis Karir & Tujuan Hidup ─────────────────────────
            [
                'category_code' => 'D2',
                'code'         => 'G05',
                'statement'    => 'Saya merasa tidak tahu harus melangkah ke mana setelah menyelesaikan studi atau dalam pekerjaan saya saat ini.',
                'reference'    => 'Robbins & Wilner (2001); Atwood & Scholtz (2008)',
                'is_critical'  => false,
                'order'        => 5,
            ],
            [
                'category_code' => 'D2',
                'code'         => 'G06',
                'statement'    => 'Saya merasa sangat takut membuat keputusan karir karena khawatir salah pilih dan menyesal seumur hidup.',
                'reference'    => 'Robbins & Wilner (2001); Petrov, Robinson & Arnett (2022) — "Lack of Clarity & Control"',
                'is_critical'  => false,
                'order'        => 6,
            ],
            [
                'category_code' => 'D2',
                'code'         => 'G07',
                'statement'    => 'Pekerjaan atau studi saya saat ini terasa tidak sesuai dengan minat, bakat, atau passion saya yang sesungguhnya.',
                'reference'    => 'Atwood & Scholtz (2008); Studi QLC Indonesia (ResearchGate, 2024)',
                'is_critical'  => false,
                'order'        => 7,
            ],
            [
                'category_code' => 'D2',
                'code'         => 'G08',
                'statement'    => 'Saya menunda-nunda (prokrastinasi) mengambil keputusan atau tindakan nyata untuk masa depan karena terlalu banyak pilihan yang membingungkan.',
                'reference'    => 'Robbins & Wilner (2001); Petrov, Robinson & Arnett (2022)',
                'is_critical'  => false,
                'order'        => 8,
            ],

            // ── DOMAIN 3: Tekanan Finansial & Kemandirian ─────────────────────
            [
                'category_code' => 'D3',
                'code'         => 'G09',
                'statement'    => 'Saya merasa tertekan dengan tuntutan untuk segera mandiri secara finansial dari keluarga atau lingkungan sekitar.',
                'reference'    => 'Atwood & Scholtz (2008); I-NAMHS (2022)',
                'is_critical'  => false,
                'order'        => 9,
            ],
            [
                'category_code' => 'D3',
                'code'         => 'G10',
                'statement'    => 'Saya khawatir berlebihan tentang kondisi keuangan saya dan kemampuan untuk mencukupi kebutuhan hidup sendiri.',
                'reference'    => 'Atwood & Scholtz (2008); Studi QLC Indonesia (ResearchGate, 2023)',
                'is_critical'  => false,
                'order'        => 10,
            ],
            [
                'category_code' => 'D3',
                'code'         => 'G11',
                'statement'    => 'Saya merasa terjebak dalam situasi finansial yang tidak ideal dan tidak tahu bagaimana cara memperbaikinya.',
                'reference'    => 'Robbins & Wilner (2001); Studi QLC Indonesia (ResearchGate, 2024)',
                'is_critical'  => false,
                'order'        => 11,
            ],
            [
                'category_code' => 'D3',
                'code'         => 'G12',
                'statement'    => 'Saya takut tidak akan pernah mencapai standar kehidupan mapan yang saya (atau keluarga saya) impikan.',
                'reference'    => 'Atwood & Scholtz (2008); Studi QLC Indonesia (ResearchGate, 2022)',
                'is_critical'  => false,
                'order'        => 12,
            ],

            // ── DOMAIN 4: Tekanan Sosial & Hubungan ───────────────────────────
            [
                'category_code' => 'D4',
                'code'         => 'G13',
                'statement'    => 'Saya merasa sangat tertekan oleh ekspektasi keluarga atau lingkungan sosial tentang apa yang harus saya capai pada usia ini.',
                'reference'    => 'Atwood & Scholtz (2008); Studi QLC Indonesia — Faktor Budaya Kolektif (2022-2024)',
                'is_critical'  => false,
                'order'        => 13,
            ],
            [
                'category_code' => 'D4',
                'code'         => 'G14',
                'statement'    => 'Saya merasa kesepian atau terisolasi secara emosional, meskipun secara fisik dikelilingi banyak orang.',
                'reference'    => 'Robbins & Wilner (2001); Petrov, Robinson & Arnett (2022) — "Disconnection"',
                'is_critical'  => false,
                'order'        => 14,
            ],
            [
                'category_code' => 'D4',
                'code'         => 'G15',
                'statement'    => 'Saya mengalami kekhawatiran tentang hubungan romantis (belum memiliki pasangan, atau merasa tidak yakin dengan hubungan yang sedang dijalani).',
                'reference'    => 'Atwood & Scholtz (2008); Studi QLC Indonesia (ResearchGate, 2023)',
                'is_critical'  => false,
                'order'        => 15,
            ],
            [
                'category_code' => 'D4',
                'code'         => 'G16',
                'statement'    => 'Saya merasa hubungan pertemanan saya semakin renggang dan sulit dipertahankan sejak memasuki fase baru kehidupan.',
                'reference'    => 'Robbins & Wilner (2001); Studi QLC Indonesia (ResearchGate, 2022)',
                'is_critical'  => false,
                'order'        => 16,
            ],

            // ── DOMAIN 5: Distress Psikologis & Eksistensial (KRITIS) ─────────
            [
                'category_code' => 'D5',
                'code'         => 'G17',
                'statement'    => 'Saya sering merasa cemas, gelisah, atau tidak tenang bahkan ketika tidak ada ancaman atau masalah nyata yang sedang terjadi.',
                'reference'    => 'Petrov, Robinson & Arnett (2022) — DCQ-12; I-NAMHS (2022)',
                'is_critical'  => true,
                'order'        => 17,
            ],
            [
                'category_code' => 'D5',
                'code'         => 'G18',
                'statement'    => 'Saya mempertanyakan makna dan tujuan keberadaan saya di dunia ini, dan seringkali tidak menemukan jawabannya.',
                'reference'    => 'Petrov, Robinson & Arnett (2022) — "loss of meaning"; Atwood & Scholtz (2008)',
                'is_critical'  => true,
                'order'        => 18,
            ],
            [
                'category_code' => 'D5',
                'code'         => 'G19',
                'statement'    => 'Saya mengalami gangguan tidur (sulit tidur atau tidur berlebihan) atau perubahan nafsu makan yang signifikan akibat pikiran-pikiran yang mengganggu.',
                'reference'    => 'Evidence-based mental health literature; I-NAMHS (2022)',
                'is_critical'  => true,
                'order'        => 19,
            ],
            [
                'category_code' => 'D5',
                'code'         => 'G20',
                'statement'    => 'Saya merasa putus asa atau tidak berdaya dalam menghadapi masa depan saya, seolah tidak ada jalan keluar.',
                'reference'    => 'Petrov, Robinson & Arnett (2022) — DCQ-12 threshold item; Robbins & Wilner (2001)',
                'is_critical'  => true,
                'order'        => 20,
            ],
        ];

        foreach ($symptoms as $data) {
            $categoryCode = $data['category_code'];
            unset($data['category_code']);

            $category = SymptomCategory::where('code', $categoryCode)->first();
            if ($category) {
                Symptom::updateOrCreate(
                    ['code' => $data['code']],
                    array_merge($data, ['symptom_category_id' => $category->id, 'is_active' => true])
                );
            }
        }
    }
}
