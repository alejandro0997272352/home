<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Subject::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nombre', 'like', "%{$request->search}%")
                  ->orWhere('codigo', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('area')) {
            $query->where('area', $request->area);
        }

        $materias = $query->orderBy('nombre')->paginate(15);
        $areas = Subject::select('area')->whereNotNull('area')->distinct()->pluck('area');

        if ($request->wantsJson()) {
            $html = view('admin.materias.partials.table', compact('materias'))->render();
            return response()->json([
                'html' => $html,
                'total' => $materias->total(),
                'page' => $materias->currentPage(),
                'pages' => $materias->lastPage(),
            ]);
        }

        return view('admin.materias.index', compact('materias', 'areas'));
    }

    public function create()
    {
        return view('admin.materias.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:200',
            'codigo' => 'nullable|string|max:20|unique:subjects',
            'descripcion' => 'nullable|string',
            'area' => 'nullable|string|max:100',
            'creditos' => 'nullable|integer|min:0',
        ]);

        Subject::create($validated);

        return redirect()->route('admin.materias.index')
            ->with('success', 'Materia creada exitosamente.');
    }

    public function show(Subject $materia)
    {
        return view('admin.materias.show', compact('materia'));
    }

    public function edit(Subject $materia)
    {
        return view('admin.materias.edit', compact('materia'));
    }

    public function update(Request $request, Subject $materia)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:200',
            'codigo' => 'nullable|string|max:20|unique:subjects,codigo,' . $materia->id,
            'descripcion' => 'nullable|string',
            'area' => 'nullable|string|max:100',
            'creditos' => 'nullable|integer|min:0',
            'activo' => 'boolean',
        ]);

        $materia->update($validated);

        return redirect()->route('admin.materias.index')
            ->with('success', 'Materia actualizada exitosamente.');
    }

    public function destroy(Subject $materia)
    {
        $materia->delete();
        return redirect()->route('admin.materias.index')
            ->with('success', 'Materia eliminada exitosamente.');
    }
}
