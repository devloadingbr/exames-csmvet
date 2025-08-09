<?php

namespace App\Http\Controllers;

use App\Models\ExamType;
use Illuminate\Http\Request;

class ExamTypeController extends Controller
{
    public function index()
    {
        $examTypes = ExamType::where('clinic_id', auth()->user()->clinic_id)
            ->orderBy('name')
            ->paginate(20);

        return view('admin.exam-types.index', compact('examTypes'));
    }

    public function create()
    {
        return view('admin.exam-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:exam_types,name,' . auth()->user()->clinic_id . ',clinic_id',
            'description' => 'nullable|string',
            'default_price' => 'nullable|numeric|min:0',
            'color' => 'nullable|string|regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/',
        ]);

        ExamType::create([
            'clinic_id' => auth()->user()->clinic_id,
            'name' => $validated['name'],
            'description' => $validated['description'],
            'default_price' => $validated['default_price'],
            'color' => $validated['color'] ?? '#6B7280',
        ]);

        return redirect()->route('admin.exam-types.index')
            ->with('success', 'Tipo de exame criado com sucesso!');
    }

    public function show(ExamType $examType)
    {
        $this->authorize('view', $examType);
        return view('admin.exam-types.show', compact('examType'));
    }

    public function edit(ExamType $examType)
    {
        $this->authorize('view', $examType);
        return view('admin.exam-types.edit', compact('examType'));
    }

    public function update(Request $request, ExamType $examType)
    {
        $this->authorize('update', $examType);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:exam_types,name,' . $examType->id . ',id,clinic_id,' . auth()->user()->clinic_id,
            'description' => 'nullable|string',
            'default_price' => 'nullable|numeric|min:0',
            'color' => 'nullable|string|regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/',
        ]);

        $examType->update($validated);

        return redirect()->route('admin.exam-types.index')
            ->with('success', 'Tipo de exame atualizado com sucesso!');
    }

    public function destroy(ExamType $examType)
    {
        $this->authorize('delete', $examType);
        
        $examType->delete();

        return redirect()->route('admin.exam-types.index')
            ->with('success', 'Tipo de exame removido com sucesso!');
    }
}