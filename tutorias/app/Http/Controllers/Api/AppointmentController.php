<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Appointment::with(['tutor', 'student', 'subject']);

        if ($user->isTutor()) {
            $query->byTutor($user->id);
        } else {
            $query->byStudent($user->id);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        return response()->json($query->orderBy('fecha', 'desc')->paginate(15));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tutor_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'fecha' => 'required|date|after_or_equal:today',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'modalidad' => 'required|in:presencial,en_linea',
            'repeat_weekly' => 'boolean',
            'repeat_until' => 'nullable|date|after:fecha|required_if:repeat_weekly,true',
        ]);

        $tutor = User::findOrFail($request->tutor_id);

        if (!$tutor->isTutor() || !$tutor->activo) {
            return response()->json(['message' => 'Tutor no disponible'], 422);
        }

        $conflicto = Appointment::where('tutor_id', $request->tutor_id)
            ->where('fecha', $request->fecha)
            ->whereIn('estado', ['pendiente', 'confirmada'])
            ->where(function ($q) use ($request) {
                $q->whereBetween('hora_inicio', [$request->hora_inicio, $request->hora_fin])
                  ->orWhereBetween('hora_fin', [$request->hora_inicio, $request->hora_fin])
                  ->orWhere(fn($q) => $q->where('hora_inicio', '<=', $request->hora_inicio)->where('hora_fin', '>=', $request->hora_fin));
            })->exists();

        if ($conflicto) {
            return response()->json(['message' => 'El tutor ya tiene una cita en ese horario'], 422);
        }

        $cita = Appointment::create([
            'tutor_id' => $request->tutor_id,
            'student_id' => $request->user()->id,
            'subject_id' => $request->subject_id,
            'fecha' => $request->fecha,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
            'modalidad' => $request->modalidad,
            'ubicacion' => $request->ubicacion,
            'notas' => $request->notas,
            'estado' => 'pendiente',
        ]);

        return response()->json($cita->load(['tutor', 'subject']), 201);
    }

    public function show(Appointment $appointment)
    {
        $user = request()->user();
        if ($appointment->tutor_id !== $user->id && $appointment->student_id !== $user->id) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        return response()->json($appointment->load(['tutor', 'student', 'subject', 'review']));
    }
}
