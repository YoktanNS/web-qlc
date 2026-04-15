<?php

namespace Database\Seeders;

use App\Models\SawCriteria;
use Illuminate\Database\Seeder;

class SawCriteriaSeeder extends Seeder
{
    public function run(): void
    {
        $criteria = [
            [
                'code'        => 'C1',
                'name'        => 'Relevansi dengan Domain Gejala Dominan',
                'description' => 'Seberapa langsung action plan ini mengatasi domain gejala yang paling dominan pada pengguna. Bobot tertinggi karena personalisasi menjadi prioritas utama.',
                'weight'      => 0.35,
                'type'        => 'benefit',
                'order'       => 1,
            ],
            [
                'code'        => 'C2',
                'name'        => 'Kemudahan Implementasi Mandiri',
                'description' => 'Seberapa mudah action plan ini dapat dilakukan secara mandiri tanpa memerlukan bantuan profesional, biaya tambahan, atau peralatan khusus.',
                'weight'      => 0.25,
                'type'        => 'benefit',
                'order'       => 2,
            ],
            [
                'code'        => 'C3',
                'name'        => 'Efektivitas Berdasarkan Literatur',
                'description' => 'Seberapa kuat dukungan evidence-based dari literatur psikologi ilmiah (CBT, MBSR, Goal-Setting Theory, dll.) terhadap efektivitas action plan ini.',
                'weight'      => 0.25,
                'type'        => 'benefit',
                'order'       => 3,
            ],
            [
                'code'        => 'C4',
                'name'        => 'Kesesuaian Profil Usia & Status',
                'description' => 'Seberapa relevan action plan ini untuk kelompok usia 18-29 tahun yang sedang dalam transisi (mahasiswa, fresh graduate, early career).',
                'weight'      => 0.15,
                'type'        => 'benefit',
                'order'       => 4,
            ],
        ];

        foreach ($criteria as $c) {
            SawCriteria::updateOrCreate(['code' => $c['code']], $c);
        }
    }
}
