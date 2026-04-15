<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActionPlan;
use App\Models\ApCriteriaScore;
use App\Models\SawCriteria;
use Illuminate\Http\Request;

class ActionPlanController extends Controller
{
    public function index()
    {
        $actionPlans = ActionPlan::with('criteriaScores.criteria')->orderBy('code')->get();
        $criteria    = SawCriteria::orderBy('order')->get();
        return view('admin.action-plans.index', compact('actionPlans', 'criteria'));
    }

    public function create()
    {
        $criteria = SawCriteria::orderBy('order')->get();
        return view('admin.action-plans.form', compact('criteria'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code'             => 'required|string|max:10|unique:action_plans,code',
            'name'             => 'required|string|max:255',
            'description'      => 'required|string',
            'category'         => 'required|in:cognitive,journaling,behavioral,mindfulness,social',
            'source_reference' => 'nullable|string',
            'how_to'           => 'nullable|string',
            'duration_minutes' => 'nullable|integer',
            'difficulty'       => 'required|in:easy,medium,hard',
            'is_active'        => 'boolean',
            'scores'           => 'required|array',
            'scores.*'         => 'required|integer|min:1|max:5',
        ]);

        $ap = ActionPlan::create(array_merge($data, ['is_active' => $request->boolean('is_active', true)]));

        foreach ($request->scores as $criteriaId => $score) {
            ApCriteriaScore::create([
                'action_plan_id'  => $ap->id,
                'saw_criteria_id' => $criteriaId,
                'score'           => $score,
            ]);
        }

        return redirect()->route('admin.action-plans.index')->with('success', 'Action plan berhasil ditambahkan.');
    }

    public function edit(ActionPlan $actionPlan)
    {
        $criteria    = SawCriteria::orderBy('order')->get();
        $scoreMap    = $actionPlan->criteriaScores->keyBy('saw_criteria_id');
        return view('admin.action-plans.form', compact('actionPlan', 'criteria', 'scoreMap'));
    }

    public function update(Request $request, ActionPlan $actionPlan)
    {
        $data = $request->validate([
            'name'             => 'required|string|max:255',
            'description'      => 'required|string',
            'category'         => 'required|in:cognitive,journaling,behavioral,mindfulness,social',
            'source_reference' => 'nullable|string',
            'how_to'           => 'nullable|string',
            'duration_minutes' => 'nullable|integer',
            'difficulty'       => 'required|in:easy,medium,hard',
            'is_active'        => 'boolean',
            'scores'           => 'required|array',
            'scores.*'         => 'required|integer|min:1|max:5',
        ]);

        $actionPlan->update(array_merge($data, ['is_active' => $request->boolean('is_active', true)]));

        foreach ($request->scores as $criteriaId => $score) {
            ApCriteriaScore::updateOrCreate(
                ['action_plan_id' => $actionPlan->id, 'saw_criteria_id' => $criteriaId],
                ['score' => $score]
            );
        }

        return redirect()->route('admin.action-plans.index')->with('success', 'Action plan berhasil diperbarui.');
    }

    public function destroy(ActionPlan $actionPlan)
    {
        $actionPlan->delete();
        return redirect()->route('admin.action-plans.index')->with('success', 'Action plan berhasil dihapus.');
    }
}
