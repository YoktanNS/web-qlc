<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FcRule;
use App\Models\QlcLevel;
use Illuminate\Http\Request;

class FcRuleController extends Controller
{
    public function index()
    {
        $rules = FcRule::with(['conditions.symptom', 'targetLevel'])->orderBy('priority')->get();
        return view('admin.fc-rules.index', compact('rules'));
    }

    public function edit(FcRule $fcRule)
    {
        $fcRule->load(['conditions.symptom', 'targetLevel']);
        $levels = QlcLevel::orderBy('score_min')->get();
        return view('admin.fc-rules.form', compact('fcRule', 'levels'));
    }

    public function update(Request $request, FcRule $fcRule)
    {
        $request->validate([
            'name'        => 'required|string',
            'description' => 'nullable|string',
            'priority'    => 'required|integer',
            'is_active'   => 'boolean',
        ]);

        $fcRule->update([
            'name'        => $request->name,
            'description' => $request->description,
            'priority'    => $request->priority,
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.fc-rules.index')->with('success', 'Rule FC berhasil diperbarui.');
    }
}
