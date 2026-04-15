<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\AssessmentResult;
use Illuminate\Http\Request;

class AssessmentReportController extends Controller
{
    public function index(Request $request)
    {
        $query = AssessmentResult::with(['assessment.user', 'qlcLevel'])
            ->join('assessments', 'assessment_results.assessment_id', '=', 'assessments.id')
            ->where('assessments.status', 'completed')
            ->select('assessment_results.*');

        // Filter level
        if ($request->filled('level')) {
            $query->whereHas('qlcLevel', fn ($q) => $q->where('code', $request->level));
        }

        // Filter tanggal
        if ($request->filled('date_from')) {
            $query->where('assessment_results.created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('assessment_results.created_at', '<=', $request->date_to . ' 23:59:59');
        }

        $results = $query->latest('assessment_results.created_at')->paginate(15);

        return view('admin.reports.index', compact('results'));
    }

    public function show(AssessmentResult $result)
    {
        $result->load([
            'qlcLevel',
            'assessment.user',
            'assessment.answers.symptom.category',
            'recommendations.actionPlan',
        ]);

        return view('admin.reports.show', compact('result'));
    }
}
