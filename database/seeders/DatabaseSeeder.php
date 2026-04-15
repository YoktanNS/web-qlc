<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,       // 1. Akun admin & user test
            QlcLevelSeeder::class,        // 2. Level QLC (none/mild/moderate/severe)
            SymptomCategorySeeder::class, // 3. Domain/kategori gejala (D1-D5)
            SymptomSeeder::class,         // 4. 20 gejala berbasis literatur
            FcRuleSeeder::class,          // 5. Aturan Forward Chaining
            SawCriteriaSeeder::class,     // 6. Kriteria SAW
            ActionPlanSeeder::class,      // 7. 12 action plan + matriks nilai SAW
        ]);
    }
}
