<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use App\Mail\CitaCancelada;
use App\Mail\NuevaCita;
use App\Models\Appointment;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with(['tutor', 'subject', 'review'])
            ->byStudent(auth()->id());

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $citas = $query->orderBy('fecha', 'desc')
            ->orderBy('hora_inicio', 'desc')
            ->paginate(15);

        return view('estudiante.citas', compact('citas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tutor_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'fecha' => 'required|date|after_or_equal:today',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'modalidad' => 'required|in:presencial,en_linea',
            'ubicacion' => 'nullable|string|max:200',
            'notas' => 'nullable|string|max:500',
            'repeat_weekly' => 'boolean',
            'repeat_until' => 'nullable|date|after:fecha|required_if:repeat_weekly,true',
        ]);

        $tutor = User::findOrFail($validated['tutor_id']);

        if (!$tutor->isTutor() || !$tutor->activo) {
            return back()->withErrors(['tutor_id' => 'El tutor no está disponible.']);
        }

        $conflicto = Appointment::where('tutor_id', $validated['tutor_id'])
            ->where('fecha', $validated['fecha'])
            ->whereIn('estado', ['pendiente', 'confirmada'])
            ->where(function ($q) use ($validated) {
                $q->whereBetween('hora_inicio', [$validated['hora_inicio'], $validated['hora_fin']])
                  ->orWhereBetween('hora_fin', [$validated['hora_inicio'], $validated['hora_fin']])
                  ->orWhere(function ($q) use ($validated) {
                      $q->where('hora_inicio', '<=', $validated['hora_inicio'])
                        ->where('hora_fin', '>=', $validated['hora_fin']);
                  });
            })
            ->exists();

        if ($conflicto) {
            return back()->withErrors(['error' => 'El tutor ya tiene una cita en ese horario.']);
        }

        $validated['student_id'] = auth()->id();
        $validated['estado'] = 'pendiente';

        $cita = Appointment::create($validated);

        if (!empty($validated['repeat_weekly']) && !empty($validated['repeat_until'])) {
            $fechaActual = \Carbon\Carbon::parse($validated['fecha'])->addWeek();
            $hasta = \Carbon\Carbon::parse($validated['repeat_until']);

            while ($fechaActual->lte($hasta)) {
                $citaRecurrente = Appointment::create([
                    'tutor_id' => $validated['tutor_id'],
                    'student_id' => auth()->id(),
                    'subject_id' => $validated['subject_id'],
                    'fecha' => $fechaActual->format('Y-m-d'),
                    'hora_inicio' => $validated['hora_inicio'],
                    'hora_fin' => $validated['hora_fin'],
                    'modalidad' => $validated['modalidad'],
                    'ubicacion' => $validated['ubicacion'] ?? null,
                    'notas' => $validated['notas'] ?? null,
                    'estado' => 'pendiente',
                    'repeat_weekly' => true,
                    'repeat_until' => $hasta->format('Y-m-d'),
                ]);

                try {
                    Mail::to($tutor->email)->send(new NuevaCita($citaRecurrente));
                } catch (\Exception $e) {}
            }
        }

        try {
            Mail::to($tutor->email)->send(new NuevaCita($cita));
        } catch (\Exception $e) {}

        Notification::createForUser($tutor->id, 'cita_nueva', 'Nueva solicitud de tutoría',
            "{$cita->student->name} ha solicitado una tutoría de {$cita->subject->nombre} para el {$cita->fecha->format('d/m/Y')}.",
            route('tutor.citas'));

        return redirect()->route('estudiante.citas')
            ->with('success', 'Solicitud de tutoría enviada exitosamente.');
    }

    public function cancel(Request $request, Appointment $appointment)
    {
        if ($appointment->student_id !== auth()->id()) {
            abort(403);
        }

        if (!in_array($appointment->estado, ['pendiente', 'confirmada'])) {
            return back()->withErrors(['error' => 'No se puede cancelar esta cita.']);
        }

        $validated = $request->validate([
            'motivo_cancelacion' => 'nullable|string|max:500',
        ]);

        $appointment->update([
            'estado' => 'cancelada',
            'motivo_cancelacion' => $validated['motivo_cancelacion'] ?? 'Cancelado por el estudiante',
            'cancelado_en' => now(),
        ]);

        try {
            Mail::to($appointment->tutor->email)->send(new CitaCancelada($appointment));
        } catch (\Exception $e) {}

        return back()->with('success', 'Cita cancelada exitosamente.');
    }
}
