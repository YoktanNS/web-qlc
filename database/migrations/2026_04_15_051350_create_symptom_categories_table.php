<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('symptom_categories', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique()->comment('Kode kategori, e.g. D1, D2');
            $table->string('name')->comment('Nama domain/kategori gejala');
            $table->text('description')->nullable()->comment('Penjelasan domain gejala');
            $table->string('icon')->nullable()->comment('Icon Bootstrap/FontAwesome');
            $table->integer('order')->default(0)->comment('Urutan tampil');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('symptom_categories');
    }
};
