<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SawCriteria;
use Illuminate\Http\Request;

class SawCriteriaController extends Controller
{
    public function index()
    {
        $criteria = SawCriteria::orderBy('order')->get();
        $totalWeight = $criteria->sum('weight');
        return view('admin.saw-criteria.index', compact('criteria', 'totalWeight'));
    }

    public function edit(SawCriteria $sawCriteria)
    {
        return view('admin.saw-criteria.form', compact('sawCriteria'));
    }

    public function update(Request $request, SawCriteria $sawCriteria)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'weight'      => 'required|numeric|min:0.01|max:1',
            'type'        => 'required|in:benefit,cost',
            'order'       => 'required|integer',
        ]);

        $sawCriteria->update($request->all());
        return redirect()->route('admin.saw-criteria.index')->with('success', 'Kriteria SAW berhasil diperbarui.');
    }
}
