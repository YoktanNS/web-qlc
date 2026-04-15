<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel header SUS (System Usability Scale)
        Schema::create('sus_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->nullable()->constrained()->nullOnDelete()
                  ->comment('Opsional — terhubung ke sesi asesmen QLC jika ada');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('guest_token', 64)->nullable()->comment('Untuk responden tanpa akun');
            $table->decimal('sus_score', 5, 2)->nullable()->comment('Skor SUS akhir (0-100)');
            $table->string('sus_grade')->nullable()->comment('Grade: A, B, C, D, F');
            $table->string('sus_adjective')->nullable()->comment('A: Excellent, B: Good, C: Okay, D: Poor, F: Awful');
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
        });

        // Tabel jawaban per pertanyaan SUS (10 pertanyaan standar)
        Schema::create('sus_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sus_assessment_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('question_number')->comment('Nomor pertanyaan 1-10');
            $table->tinyInteger('score')->comment('Pilihan Likert 1-5');
            $table->timestamps();

            $table->unique(['sus_assessment_id', 'question_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sus_answers');
        Schema::dropIfExists('sus_assessments');
    }
};
