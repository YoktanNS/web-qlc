<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$admin = User::where('email', 'admin@qlc-system.id')->first();
$user  = User::where('email', 'user@qlc-system.id')->first();

echo "=== VERIFIKASI AKUN ===" . PHP_EOL;
echo "Admin : " . ($admin ? $admin->email : 'TIDAK DITEMUKAN') . PHP_EOL;
echo "  Role    : " . ($admin->role ?? '-') . PHP_EOL;
echo "  PW 2026 : " . (Hash::check('Admin@QLC2026', $admin->password ?? '') ? 'BENAR ✓' : 'SALAH ✗') . PHP_EOL;
echo "  PW 2025 : " . (Hash::check('Admin@QLC2025', $admin->password ?? '') ? 'BENAR ✓' : 'SALAH ✗') . PHP_EOL;

echo PHP_EOL;
echo "User  : " . ($user ? $user->email : 'TIDAK DITEMUKAN') . PHP_EOL;
echo "  Role    : " . ($user->role ?? '-') . PHP_EOL;
echo "  PW 2026 : " . (Hash::check('User@QLC2026', $user->password ?? '') ? 'BENAR ✓' : 'SALAH ✗') . PHP_EOL;
echo "  PW 2025 : " . (Hash::check('User@QLC2025', $user->password ?? '') ? 'BENAR ✓' : 'SALAH ✗') . PHP_EOL;
