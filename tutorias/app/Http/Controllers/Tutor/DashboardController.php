<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $proximasCitas = Appointment::with(['student', 'subject'])
            ->byTutor($user->id)
            ->whereIn('estado', ['pendiente', 'confirmada'])
            ->whereDate('fecha', '>=', today())
            ->orderBy('fecha')
            ->orderBy('hora_inicio')
            ->take(5)
            ->get();

        $totalCitas = $user->tutorAppointments()->count();
        $citasCompletadas = $user->tutorAppointments()->where('estado', 'completada')->count();
        $citasPendientes = $user->tutorAppointments()->where('estado', 'pendiente')->count();
        $citasHoy = $user->tutorAppointments()->whereDate('fecha', today())->count();

        $materias = $user->subjects;

        $driver = DB::getDriverName();
        $rawMonth = $driver === 'pgsql' ? "EXTRACT(MONTH FROM fecha)" : "MONTH(fecha)";

        $citasPorMes = Appointment::select(
            DB::raw("{$rawMonth} as mes"),
            DB::raw('COUNT(*) as total')
        )
            ->byTutor($user->id)
            ->whereYear('fecha', now()->year)
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $estados = Appointment::select('estado', DB::raw('COUNT(*) as total'))
            ->byTutor($user->id)
            ->groupBy('estado')
            ->pluck('total', 'estado');

        $citasCanceladas = $user->tutorAppointments()->where('estado', 'cancelada')->count();
        $citasConfirmadas = $user->tutorAppointments()->where('estado', 'confirmada')->count();
        $horasTotales = $user->tutorAppointments()
            ->where('estado', 'completada')
            ->get()
            ->sum(fn($c) => $c->hora_inicio && $c->hora_fin
                ? abs(strtotime($c->hora_fin) - strtotime($c->hora_inicio)) / 3600
                : 0);

        return view('tutor.dashboard', compact(
            'proximasCitas', 'totalCitas', 'citasCompletadas',
            'citasPendientes', 'citasHoy', 'materias', 'citasPorMes',
            'estados', 'citasCanceladas', 'citasConfirmadas', 'horasTotales'
        ));
    }
}
