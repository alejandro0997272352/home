<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Availability;
use App\Models\User;
use Illuminate\Http\Request;

class TutorController extends Controller
{
    public function index(Request $request)
    {
        $tutores = User::tutores()->with(['tutorProfile', 'subjects']);

        if ($request->filled('search')) {
            $tutores->where('name', 'like', "%{$request->search}%");
        }

        if ($request->filled('subject_id')) {
            $tutores->whereHas('subjects', fn($q) => $q->where('subject_id', $request->subject_id));
        }

        return response()->json($tutores->paginate(15));
    }

    public function show(User $user)
    {
        if (!$user->isTutor() || !$user->activo) {
            return response()->json(['message' => 'Tutor no encontrado'], 404);
        }

        $user->load(['tutorProfile', 'subjects', 'availability' => function ($q) {
            $q->where('activo', true);
        }]);

        return response()->json($user);
    }

    public function availability(User $user)
    {
        if (!$user->isTutor() || !$user->activo) {
            return response()->json(['message' => 'Tutor no encontrado'], 404);
        }

        $horarios = $user->availability()
            ->where('activo', true)
            ->orderByRaw("FIELD(dia_semana, 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado')")
            ->get()
            ->groupBy('dia_semana');

        return response()->json($horarios);
    }
}
