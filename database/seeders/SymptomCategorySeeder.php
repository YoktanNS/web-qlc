<?php

namespace Database\Seeders;

use App\Models\SymptomCategory;
use Illuminate\Database\Seeder;

class SymptomCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'code'        => 'D1',
                'name'        => 'Kebingungan Identitas Diri',
                'description' => 'Domain yang mengukur tingkat kebingungan dan ketidakjelasan mengenai jati diri, nilai-nilai hidup, serta tujuan eksistensial. Berdasarkan DCQ-12 subskala "Disconnection & Distress" (Petrov et al., 2022) dan dimensi identitas Atwood & Scholtz (2008).',
                'icon'        => 'bi-person-question',
                'order'       => 1,
            ],
            [
                'code'        => 'D2',
                'name'        => 'Krisis Karir & Tujuan Hidup',
                'description' => 'Domain yang mengukur kecemasan, ketidakpastian, dan prokrastinasi terkait keputusan karir dan arah masa depan. Berdasarkan subskala "Lack of Clarity & Control" DCQ-12 (Petrov et al., 2022) dan Robbins & Wilner (2001).',
                'icon'        => 'bi-briefcase',
                'order'       => 2,
            ],
            [
                'code'        => 'D3',
                'name'        => 'Tekanan Finansial & Kemandirian',
                'description' => 'Domain yang mengukur tekanan dan kecemasan berkaitan dengan kondisi finansial dan tuntutan kemandirian ekonomi. Berdasarkan Atwood & Scholtz (2008) dan studi QLC Indonesia 2022-2024.',
                'icon'        => 'bi-currency-dollar',
                'order'       => 3,
            ],
            [
                'code'        => 'D4',
                'name'        => 'Tekanan Sosial & Hubungan',
                'description' => 'Domain yang mengukur dampak ekspektasi sosial, keluarga, relasi pertemanan, dan hubungan romantis. Diperkuat dengan faktor budaya kolektif Indonesia berdasarkan studi ResearchGate 2022-2024.',
                'icon'        => 'bi-people',
                'order'       => 4,
            ],
            [
                'code'        => 'D5',
                'name'        => 'Distress Psikologis & Eksistensial',
                'description' => 'Domain kritis yang mengukur gejala psikologis berat: kecemasan, kehilangan makna, gangguan tidur, dan hopelessness. Berdasarkan subskala "Disconnection & Distress" DCQ-12 (Petrov et al., 2022) dan data I-NAMHS (2022).',
                'icon'        => 'bi-brain',
                'order'       => 5,
            ],
        ];

        foreach ($categories as $cat) {
            SymptomCategory::updateOrCreate(['code' => $cat['code']], $cat);
        }
    }
}
