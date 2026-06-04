<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Mail\CitaCancelada;
use App\Mail\CitaConfirmada;
use App\Models\Appointment;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with(['student', 'subject'])
            ->byTutor(auth()->id());

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('fecha')) {
            $query->whereDate('fecha', $request->fecha);
        }

        $citas = $query->orderBy('fecha', 'desc')
            ->orderBy('hora_inicio', 'desc')
            ->paginate(15);

        return view('tutor.citas', compact('citas'));
    }

    public function confirm(Appointment $appointment)
    {
        if ($appointment->tutor_id !== auth()->id() || $appointment->estado !== 'pendiente') {
            abort(403);
        }

        $appointment->update(['estado' => 'confirmada']);

        try {
            Mail::to($appointment->student->email)->send(new CitaConfirmada($appointment));
        } catch (\Exception $e) {}

        Notification::createForUser($appointment->student_id, 'cita_confirmada', 'Tutoría confirmada',
            "Tu tutoría de {$appointment->subject->nombre} con {$appointment->tutor->name} ha sido confirmada para el {$appointment->fecha->format('d/m/Y')}.",
            route('estudiante.citas'));

        return back()->with('success', 'Cita confirmada exitosamente.');
    }

    public function complete(Appointment $appointment)
    {
        if ($appointment->tutor_id !== auth()->id() || $appointment->estado !== 'confirmada') {
            abort(403);
        }

        $appointment->update(['estado' => 'completada']);

        auth()->user()->tutorProfile->syncStats();

        Notification::createForUser($appointment->student_id, 'cita_completada', 'Tutoría completada',
            "Tu tutoría de {$appointment->subject->nombre} con {$appointment->tutor->name} ha sido marcada como completada. ¡Cuéntanos cómo te fue!",
            route('estudiante.citas'));

        return back()->with('success', 'Cita marcada como completada.');
    }

    public function cancel(Request $request, Appointment $appointment)
    {
        if ($appointment->tutor_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'motivo_cancelacion' => 'required|string|max:500',
        ]);

        $appointment->update([
            'estado' => 'cancelada',
            'motivo_cancelacion' => $validated['motivo_cancelacion'],
            'cancelado_en' => now(),
        ]);

        try {
            Mail::to($appointment->student->email)->send(new CitaCancelada($appointment));
        } catch (\Exception $e) {}

        Notification::createForUser($appointment->student_id, 'cita_cancelada', 'Tutoría cancelada',
            "Tu tutoría de {$appointment->subject->nombre} con {$appointment->tutor->name} para el {$appointment->fecha->format('d/m/Y')} ha sido cancelada.",
            route('estudiante.citas'));

        return back()->with('success', 'Cita cancelada.');
    }
}
