<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\Availability;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $horarios = $user->availability()->orderByRaw(
            "FIELD(dia_semana, 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado')"
        )->get();

        $dias = Availability::dias();
        $agrupado = $horarios->groupBy('dia_semana');

        return view('tutor.disponibilidad', compact('horarios', 'dias', 'agrupado'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'dia_semana' => 'required|in:' . implode(',', Availability::dias()),
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
        ]);

        $overlap = Availability::where('user_id', auth()->id())
            ->where('dia_semana', $validated['dia_semana'])
            ->where(function ($q) use ($validated) {
                $q->whereBetween('hora_inicio', [$validated['hora_inicio'], $validated['hora_fin']])
                  ->orWhereBetween('hora_fin', [$validated['hora_inicio'], $validated['hora_fin']])
                  ->orWhere(function ($q) use ($validated) {
                      $q->where('hora_inicio', '<=', $validated['hora_inicio'])
                        ->where('hora_fin', '>=', $validated['hora_fin']);
                  });
            })
            ->exists();

        if ($overlap) {
            return back()->withErrors(['error' => 'El horario se superpone con uno existente.']);
        }

        auth()->user()->availability()->create($validated);

        return back()->with('success', 'Disponibilidad agregada exitosamente.');
    }

    public function destroy(Availability $availability)
    {
        if ($availability->user_id !== auth()->id()) {
            abort(403);
        }

        $availability->delete();
        return back()->with('success', 'Disponibilidad eliminada.');
    }
}
