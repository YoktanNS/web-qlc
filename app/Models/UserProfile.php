<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id', 'age', 'gender', 'education_status', 'institution',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getGenderLabelAttribute(): string
    {
        return match ($this->gender) {
            'male'              => 'Laki-laki',
            'female'            => 'Perempuan',
            'prefer_not_to_say' => 'Tidak ingin menyebutkan',
            default             => '-',
        };
    }

    public function getEducationLabelAttribute(): string
    {
        return match ($this->education_status) {
            'sma_smk'        => 'SMA/SMK',
            'mahasiswa_d3'   => 'Mahasiswa D3',
            'mahasiswa_s1'   => 'Mahasiswa S1',
            'mahasiswa_s2'   => 'Mahasiswa S2/Pascasarjana',
            'fresh_graduate' => 'Fresh Graduate',
            'bekerja'        => 'Sudah Bekerja',
            'wirausaha'      => 'Wirausaha',
            'tidak_bekerja'  => 'Belum/Tidak Bekerja',
            'lainnya'        => 'Lainnya',
            default          => '-',
        };
    }
}
