<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Availability;
use App\Models\Subject;
use App\Models\Review;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $materias = Subject::activas()->orderBy('nombre')->get();

        $tutores = User::tutores()->with(['tutorProfile', 'subjects']);

        if ($request->filled('search')) {
            $tutores->where('name', 'like', "%{$request->search}%");
        }

        if ($request->filled('subject_id')) {
            $tutores->whereHas('subjects', function ($q) use ($request) {
                $q->where('subject_id', $request->subject_id);
            });
        }

        if ($request->filled('dia')) {
            $tutores->whereHas('availability', function ($q) use ($request) {
                $q->where('dia_semana', $request->dia);
            });
        }

        $tutores = $tutores->paginate(12);

        $dias = Availability::dias();

        return view('estudiante.buscar', compact('tutores', 'materias', 'dias'));
    }

    public function show(User $user)
    {
        if (!$user->isTutor() || !$user->activo) {
            abort(404);
        }

        $user->load(['tutorProfile', 'subjects', 'availability' => function ($q) {
            $q->where('activo', true)->orderByRaw("FIELD(dia_semana, 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado')");
        }]);

        $reviews = Review::whereHas('appointment', function ($q) use ($user) {
            $q->where('tutor_id', $user->id)->where('estado', 'completada');
        })->with('user')->latest()->get();

        $stats = [
            'total_sesiones' => $user->tutorProfile?->total_sesiones ?? 0,
            'calificacion_promedio' => $user->tutorProfile?->calificacion_promedio ?? 0,
            'total_reviews' => $reviews->count(),
            'materias_count' => $user->subjects->count(),
        ];

        return view('estudiante.tutor-profile', compact('user', 'reviews', 'stats'));
    }

    public function tutorAvailability(User $user)
    {
        if (!$user->isTutor() || !$user->activo) {
            abort(404);
        }

        $horarios = $user->availability()
            ->where('activo', true)
            ->orderByRaw("FIELD(dia_semana, 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado')")
            ->get()
            ->groupBy('dia_semana');

        $materias = $user->subjects;

        return response()->json([
            'horarios' => $horarios,
            'materias' => $materias,
        ]);
    }
}
