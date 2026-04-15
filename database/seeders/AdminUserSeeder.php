<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Gunakan tap() agar password selalu diperbarui meski record sudah ada
        $admin = User::firstOrNew(['email' => 'admin@qlc-system.id']);
        $admin->fill([
            'name'     => 'Administrator',
            'password' => Hash::make('Admin@QLC2026'),
            'role'     => 'admin',
            'is_guest' => false,
        ])->save();

        $user = User::firstOrNew(['email' => 'user@qlc-system.id']);
        $user->fill([
            'name'     => 'Test User',
            'password' => Hash::make('User@QLC2026'),
            'role'     => 'user',
            'is_guest' => false,
        ])->save();
    }
}
