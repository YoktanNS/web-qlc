<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recommendation_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_result_id')->constrained()->onDelete('cascade');
            $table->foreignId('action_plan_id')->constrained()->onDelete('cascade');
            $table->decimal('saw_raw_score', 8, 4)->comment('Skor SAW sebelum normalisasi');
            $table->decimal('saw_normalized_score', 8, 4)->comment('Skor SAW setelah normalisasi (0-1)');
            $table->decimal('saw_final_score', 8, 4)->comment('Skor akhir SAW terbobot');
            $table->integer('rank')->comment('Peringkat akhir rekomendasi');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recommendation_results');
    }
};
