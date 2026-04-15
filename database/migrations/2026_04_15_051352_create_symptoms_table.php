<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('symptoms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('symptom_category_id')->constrained()->onDelete('cascade');
            $table->string('code', 10)->unique()->comment('Kode gejala, e.g. G01');
            $table->text('statement')->comment('Pernyataan gejala yang ditampilkan ke pengguna');
            $table->text('reference')->nullable()->comment('Referensi literatur sumber gejala');
            $table->boolean('is_critical')->default(false)->comment('Apakah ini gejala kritis (G17-G20) untuk rule khusus FC');
            $table->integer('order')->default(0)->comment('Urutan tampil dalam kuesioner');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('symptoms');
    }
};
