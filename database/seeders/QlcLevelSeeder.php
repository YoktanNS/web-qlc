<?php

namespace Database\Seeders;

use App\Models\QlcLevel;
use Illuminate\Database\Seeder;

class QlcLevelSeeder extends Seeder
{
    public function run(): void
    {
        $levels = [
            [
                'code'              => 'none',
                'name'              => 'Tidak Terdeteksi QLC',
                'score_min'         => 0,
                'score_max'         => 19,
                'description'       => 'Berdasarkan jawaban Anda, sistem tidak mendeteksi indikasi Quarter-Life Crisis yang signifikan. Anda mungkin mengalami tekanan biasa yang wajar di usia ini.',
                'advice'            => 'Pertahankan keseimbangan hidup Anda. Terus kembangkan diri dan jaga kesehatan mental dengan aktivitas positif.',
                'color_class'       => 'success',
                'icon'              => 'bi-check-circle-fill',
                'allow_action_plan' => false,
            ],
            [
                'code'              => 'mild',
                'name'              => 'QLC Ringan',
                'score_min'         => 20,
                'score_max'         => 39,
                'description'       => 'Anda menunjukkan beberapa gejala Quarter-Life Crisis pada tingkat ringan. Ini adalah hal yang umum dan dapat ditangani secara mandiri dengan langkah-langkah yang tepat.',
                'advice'            => 'Ambil langkah kecil namun konsisten. Action plan berikut dirancang untuk membantu Anda menavigasi fase ini dengan lebih baik.',
                'color_class'       => 'info',
                'icon'              => 'bi-info-circle-fill',
                'allow_action_plan' => true,
            ],
            [
                'code'              => 'moderate',
                'name'              => 'QLC Sedang',
                'score_min'         => 40,
                'score_max'         => 59,
                'description'       => 'Anda menunjukkan gejala Quarter-Life Crisis pada tingkat sedang. Kondisi ini memerlukan perhatian lebih serius dan penanganan yang lebih terstruktur.',
                'advice'            => 'Jangan hadapi ini sendirian. Selain action plan mandiri di bawah ini, pertimbangkan untuk berbicara dengan orang terpercaya atau konselor kampus.',
                'color_class'       => 'warning',
                'icon'              => 'bi-exclamation-triangle-fill',
                'allow_action_plan' => true,
            ],
            [
                'code'              => 'severe',
                'name'              => 'QLC Berat',
                'score_min'         => 60,
                'score_max'         => 80,
                'description'       => 'Anda menunjukkan gejala Quarter-Life Crisis pada tingkat berat. Kondisi ini memerlukan bantuan dari tenaga psikologi profesional sesegera mungkin.',
                'advice'            => 'Sistem ini merekomendasikan Anda untuk segera menjadwalkan sesi konsultasi dengan Psikolog profesional. Ini bukan tanda kelemahan — ini adalah langkah terkuat yang bisa Anda ambil.',
                'color_class'       => 'danger',
                'icon'              => 'bi-heart-pulse-fill',
                'allow_action_plan' => false,
            ],
        ];

        foreach ($levels as $level) {
            QlcLevel::updateOrCreate(['code' => $level['code']], $level);
        }
    }
}
