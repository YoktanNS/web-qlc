<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessment_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained()->onDelete('cascade');
            $table->foreignId('symptom_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('likert_score')->comment('Nilai Likert yang dipilih pengguna: 1-5');
            $table->tinyInteger('weighted_score')->comment('Poin yang dihitung: likert_score - 1 (0-4)');
            $table->timestamps();

            $table->unique(['assessment_id', 'symptom_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessment_answers');
    }
};
