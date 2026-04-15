<?php

namespace App\Http\Controllers;

use App\Models\AssessmentResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    /**
     * Tampilkan halaman hasil diagnosa lengkap.
     */
    public function show(AssessmentResult $result)
    {
        // Load semua relasi yang dibutuhkan
        $result->load([
            'qlcLevel',
            'assessment.user',
            'recommendations' => fn ($q) => $q->orderBy('rank')->with('actionPlan'),
        ]);

        $assessment = $result->assessment;

        // Keamanan: hanya pemilik atau admin yang bisa akses
        if (Auth::check()) {
            if (!Auth::user()->isAdmin() && $assessment->user_id !== Auth::id()) {
                abort(403, 'Anda tidak memiliki akses ke hasil ini.');
            }
        } else {
            // Guest: cek token cookie
            $guestToken = request()->cookie('guest_token');
            if ($assessment->guest_token !== $guestToken) {
                abort(403, 'Akses tidak valid.');
            }
        }

        $level           = $result->qlcLevel;
        $domainScores    = $result->domain_scores ?? [];
        $fcRulesFired    = $result->fc_rules_fired ?? [];
        $recommendations = $result->recommendations;

        return view('result.show', compact(
            'result', 'assessment', 'level', 'domainScores', 'fcRulesFired', 'recommendations'
        ));
    }

    /**
     * Riwayat asesmen pengguna yang login.
     */
    public function history()
    {
        $assessments = Auth::user()
            ->assessments()
            ->where('status', 'completed')
            ->with('result.qlcLevel')
            ->latest('completed_at')
            ->paginate(10);

        return view('result.history', compact('assessments'));
    }
}
