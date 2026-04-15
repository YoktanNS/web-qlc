<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ap_criteria_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('action_plan_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('saw_criteria_id');
            $table->foreign('saw_criteria_id')->references('id')->on('saw_criteria')->onDelete('cascade');
            $table->integer('score')->comment('Nilai action plan pada kriteria ini (skala 1-5)');
            $table->timestamps();

            $table->unique(['action_plan_id', 'saw_criteria_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ap_criteria_scores');
    }
};
