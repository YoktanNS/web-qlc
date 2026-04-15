<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('age')->nullable()->comment('Usia pengguna');
            $table->enum('gender', ['male', 'female', 'prefer_not_to_say'])->nullable()->comment('Jenis kelamin');
            $table->enum('education_status', [
                'sma_smk',
                'mahasiswa_d3',
                'mahasiswa_s1',
                'mahasiswa_s2',
                'fresh_graduate',
                'bekerja',
                'wirausaha',
                'tidak_bekerja',
                'lainnya'
            ])->nullable()->comment('Status pendidikan/pekerjaan');
            $table->string('institution')->nullable()->comment('Universitas/Perusahaan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
