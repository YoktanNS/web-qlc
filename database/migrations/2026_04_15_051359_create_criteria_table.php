<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('saw_criteria', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique()->comment('Kode kriteria, e.g. C1');
            $table->string('name')->comment('Nama kriteria SAW');
            $table->text('description')->nullable()->comment('Penjelasan kriteria');
            $table->decimal('weight', 4, 2)->comment('Bobot kriteria (total harus = 1.00)');
            $table->enum('type', ['benefit', 'cost'])->default('benefit')
                  ->comment('Jenis: benefit=semakin tinggi semakin baik, cost=semakin rendah semakin baik');
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saw_criteria');
    }
};
