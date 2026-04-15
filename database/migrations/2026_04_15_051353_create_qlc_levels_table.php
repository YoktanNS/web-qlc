<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('qlc_levels', function (Blueprint $table) {
            $table->id();
            $table->enum('code', ['none', 'mild', 'moderate', 'severe'])
                  ->unique()
                  ->comment('Kode level: none=Tidak Terdeteksi, mild=Ringan, moderate=Sedang, severe=Berat');
            $table->string('name')->comment('Nama tampilan level');
            $table->integer('score_min')->comment('Skor minimum (inklusif)');
            $table->integer('score_max')->comment('Skor maksimum (inklusif)');
            $table->text('description')->nullable()->comment('Penjelasan level untuk pengguna');
            $table->text('advice')->nullable()->comment('Saran umum untuk level ini');
            $table->string('color_class')->nullable()->comment('Warna Bootstrap badge, e.g. success, warning, danger');
            $table->string('icon')->nullable()->comment('Icon untuk tampilan hasil');
            $table->boolean('allow_action_plan')->default(true)->comment('Apakah level ini mendapat rekomendasi action plan mandiri');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('qlc_levels');
    }
};
