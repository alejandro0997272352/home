<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\TutorProfile;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Appointment $appointment)
    {
        $request->validate([
            'calificacion' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:500',
        ]);

        if ($appointment->student_id !== auth()->id()) {
            return back()->with('error', 'No puedes calificar esta cita.');
        }
        if ($appointment->estado !== 'completada') {
            return back()->with('error', 'Solo puedes calificar citas completadas.');
        }
        if ($appointment->review) {
            return back()->with('error', 'Ya calificaste esta cita.');
        }

        $appointment->review()->create([
            'user_id' => auth()->id(),
            'calificacion' => $request->calificacion,
            'comentario' => $request->comentario,
        ]);

        $profile = TutorProfile::firstOrCreate(
            ['user_id' => $appointment->tutor_id],
            ['user_id' => $appointment->tutor_id]
        );
        $profile->syncStats();

        return back()->with('success', 'Calificación enviada correctamente.');
    }
}
