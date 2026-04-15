<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Symptom;
use App\Models\SymptomCategory;
use Illuminate\Http\Request;

class SymptomController extends Controller
{
    public function index()
    {
        $categories = SymptomCategory::with(['symptoms' => fn ($q) => $q->orderBy('order')])->orderBy('order')->get();
        return view('admin.symptoms.index', compact('categories'));
    }

    public function create()
    {
        $categories = SymptomCategory::orderBy('order')->get();
        return view('admin.symptoms.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'symptom_category_id' => 'required|exists:symptom_categories,id',
            'code'                => 'required|string|max:10|unique:symptoms,code',
            'statement'           => 'required|string',
            'reference'           => 'nullable|string',
            'is_critical'         => 'boolean',
            'order'               => 'required|integer',
        ]);

        Symptom::create(array_merge($request->all(), [
            'is_critical' => $request->boolean('is_critical'),
            'is_active'   => $request->boolean('is_active', true),
        ]));

        return redirect()->route('admin.symptoms.index')->with('success', 'Gejala berhasil ditambahkan.');
    }

    public function edit(Symptom $symptom)
    {
        $categories = SymptomCategory::orderBy('order')->get();
        return view('admin.symptoms.form', compact('symptom', 'categories'));
    }

    public function update(Request $request, Symptom $symptom)
    {
        $request->validate([
            'symptom_category_id' => 'required|exists:symptom_categories,id',
            'statement'           => 'required|string',
            'reference'           => 'nullable|string',
            'is_critical'         => 'boolean',
            'order'               => 'required|integer',
        ]);

        $symptom->update(array_merge($request->all(), [
            'is_critical' => $request->boolean('is_critical'),
            'is_active'   => $request->boolean('is_active', true),
        ]));

        return redirect()->route('admin.symptoms.index')->with('success', 'Gejala berhasil diperbarui.');
    }

    public function destroy(Symptom $symptom)
    {
        $symptom->delete();
        return redirect()->route('admin.symptoms.index')->with('success', 'Gejala berhasil dihapus.');
    }
}
