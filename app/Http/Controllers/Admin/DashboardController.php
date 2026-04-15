<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\QlcLevel;
use App\Models\SusAssessment;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik utama
        $stats = [
            'total_users'       => User::where('role', 'user')->where('is_guest', false)->count(),
            'total_assessments' => Assessment::where('status', 'completed')->count(),
            'total_sus'         => SusAssessment::whereNotNull('sus_score')->count(),
            'avg_sus_score'     => round(SusAssessment::whereNotNull('sus_score')->avg('sus_score') ?? 0, 1),
        ];

        // Distribusi level QLC
        $levelDistribution = DB::table('assessment_results')
            ->join('qlc_levels', 'assessment_results.qlc_level_id', '=', 'qlc_levels.id')
            ->select('qlc_levels.name', 'qlc_levels.code', 'qlc_levels.color_class', DB::raw('COUNT(*) as total'))
            ->groupBy('qlc_levels.id', 'qlc_levels.name', 'qlc_levels.code', 'qlc_levels.color_class')
            ->orderBy('qlc_levels.score_min')
            ->get();

        // Asesmen terbaru
        $recentAssessments = Assessment::where('status', 'completed')
            ->with(['user', 'result.qlcLevel'])
            ->latest('completed_at')
            ->take(10)
            ->get();

        // Tren asesmen per bulan (6 bulan terakhir)
        $monthlyTrend = DB::table('assessments')
            ->where('status', 'completed')
            ->where('completed_at', '>=', now()->subMonths(6))
            ->select(DB::raw('YEAR(completed_at) as year, MONTH(completed_at) as month, COUNT(*) as total'))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        return view('admin.dashboard', compact(
            'stats', 'levelDistribution', 'recentAssessments', 'monthlyTrend'
        ));
    }
}
