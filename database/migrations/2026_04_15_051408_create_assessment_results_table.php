<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessment_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->unique()->constrained()->onDelete('cascade');
            $table->foreignId('qlc_level_id')->constrained()->comment('Level QLC hasil Forward Chaining');
            $table->integer('total_score')->comment('Total skor agregat seluruh gejala (0-80)');
            $table->integer('base_level_score')->comment('Level berdasarkan skor dasar sebelum aturan FC tambahan');
            $table->string('dominant_domain')->nullable()->comment('Domain gejala dengan skor tertinggi');
            $table->json('domain_scores')->nullable()->comment('Skor per domain dalam format JSON');
            $table->json('fc_rules_fired')->nullable()->comment('Daftar kode rule FC yang aktif/terpenuhi');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessment_results');
    }
};
