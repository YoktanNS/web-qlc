<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel rule Forward Chaining untuk aturan eskalasi level
        Schema::create('fc_rules', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique()->comment('Kode rule, e.g. R1, R2');
            $table->string('name')->comment('Nama deskriptif rule');
            $table->text('description')->nullable()->comment('Deskripsi logika rule');
            $table->integer('priority')->default(10)->comment('Prioritas eksekusi, lebih kecil = lebih prioritas');
            $table->foreignId('target_level_id')->nullable()->constrained('qlc_levels')->nullOnDelete()
                  ->comment('Target level jika rule ini terpenuhi');
            $table->enum('action_type', ['set_level', 'escalate_one', 'set_minimum'])
                  ->default('set_level')
                  ->comment('Jenis aksi: set_level=set langsung, escalate_one=naik 1 tingkat, set_minimum=naik ke minimum level');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Tabel kondisi per rule (AND conditions)
        Schema::create('fc_rule_conditions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fc_rule_id')->constrained()->onDelete('cascade');
            $table->enum('condition_type', ['symptom_score', 'total_score', 'critical_count'])
                  ->comment('Jenis kondisi: symptom_score=skor satu gejala, total_score=total semua, critical_count=jumlah gejala kritis');
            $table->foreignId('symptom_id')->nullable()->constrained()->nullOnDelete()
                  ->comment('Gejala yang dievaluasi (null jika condition_type bukan symptom_score)');
            $table->enum('operator', ['>=', '<=', '=', '>', '<'])->default('>=');
            $table->integer('value')->comment('Nilai threshold untuk perbandingan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fc_rule_conditions');
        Schema::dropIfExists('fc_rules');
    }
};
