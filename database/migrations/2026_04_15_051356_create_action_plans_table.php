<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('action_plans', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique()->comment('Kode action plan, e.g. AP01');
            $table->string('name')->comment('Nama action plan');
            $table->text('description')->comment('Deskripsi detail cara pelaksanaan');
            $table->enum('category', ['cognitive', 'journaling', 'behavioral', 'mindfulness', 'social'])
                  ->comment('Kategori: cognitive=CBT, journaling=refleksi diri, behavioral=perubahan perilaku, mindfulness=kesadaran penuh, social=dukungan sosial');
            $table->string('source_reference')->nullable()->comment('Sumber literatur');
            $table->text('how_to')->nullable()->comment('Langkah-langkah praktis pelaksanaan');
            $table->integer('duration_minutes')->nullable()->comment('Estimasi durasi (menit)');
            $table->enum('difficulty', ['easy', 'medium', 'hard'])->default('easy')->comment('Tingkat kesulitan pelaksanaan mandiri');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('action_plans');
    }
};
