<?php

use App\Http\Controllers\Admin\ActionPlanController;
use App\Http\Controllers\Admin\AssessmentReportController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FcRuleController;
use App\Http\Controllers\Admin\SawCriteriaController;
use App\Http\Controllers\Admin\SymptomController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\SUSController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

// ─── Halaman Publik ──────────────────────────────────────────────────────────

Route::get('/', function () {
    return view('welcome');
})->name('home');

// ─── Auth (Breeze) ───────────────────────────────────────────────────────────

require __DIR__ . '/auth.php';

// ─── Profil Pengguna (Auth Required) ─────────────────────────────────────────

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', function () {
        return redirect()->route('assessment.intro');
    })->name('dashboard');

    // Riwayat asesmen (hanya pengguna login)
    Route::get('/riwayat', [ResultController::class, 'history'])->name('result.history');
});

// ─── Kuesioner (Bisa Guest atau Login) ───────────────────────────────────────

Route::prefix('kuesioner')->name('assessment.')->group(function () {
    Route::get('/',         [AssessmentController::class, 'intro'])->name('intro');
    Route::post('/mulai',   [AssessmentController::class, 'start'])->name('start');
    Route::get('/{step}',   [AssessmentController::class, 'question'])->name('question')->where('step', '[0-9]+');
    Route::post('/{step}',  [AssessmentController::class, 'saveAnswers'])->name('save')->where('step', '[0-9]+');
});

// ─── Halaman Hasil ───────────────────────────────────────────────────────────

Route::prefix('hasil')->name('result.')->group(function () {
    Route::get('/{result}', [ResultController::class, 'show'])->name('show');
});

// ─── SUS (System Usability Scale) ────────────────────────────────────────────

Route::prefix('sus')->name('sus.')->group(function () {
    Route::get('/form',         [SUSController::class, 'form'])->name('form');
    Route::post('/submit',      [SUSController::class, 'submit'])->name('submit');
    Route::get('/hasil/{sus}',  [SUSController::class, 'result'])->name('result');
});

// ─── Panel Admin ─────────────────────────────────────────────────────────────

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', AdminMiddleware::class])
    ->group(function () {

        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Manajemen Gejala
        Route::resource('gejala', SymptomController::class)
            ->names('symptoms')
            ->parameters(['gejala' => 'symptom']);

        // Manajemen Action Plan
        Route::resource('action-plans', ActionPlanController::class)
            ->names('action-plans');

        // Manajemen Kriteria SAW
        Route::resource('kriteria-saw', SawCriteriaController::class)
            ->names('saw-criteria')
            ->parameters(['kriteria-saw' => 'sawCriteria']);

        // Manajemen Aturan FC
        Route::resource('fc-rules', FcRuleController::class)
            ->names('fc-rules');

        // Laporan Asesmen
        Route::get('laporan',          [AssessmentReportController::class, 'index'])->name('reports.index');
        Route::get('laporan/{result}', [AssessmentReportController::class, 'show'])->name('reports.show');

        // Manajemen Pengguna
        Route::get('pengguna',             [UserController::class, 'index'])->name('users.index');
        Route::delete('pengguna/{user}',   [UserController::class, 'destroy'])->name('users.destroy');
    });
