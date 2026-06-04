<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use App\Models\Appointment;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $proximasCitas = Appointment::with(['tutor', 'subject'])
            ->byStudent($user->id)
            ->whereIn('estado', ['pendiente', 'confirmada'])
            ->whereDate('fecha', '>=', today())
            ->orderBy('fecha')
            ->orderBy('hora_inicio')
            ->take(5)
            ->get();

        $totalCitas = $user->studentAppointments()->count();
        $citasCompletadas = $user->studentAppointments()->where('estado', 'completada')->count();
        $citasPendientes = $user->studentAppointments()->where('estado', 'pendiente')->count();
        $citasCanceladas = $user->studentAppointments()->where('estado', 'cancelada')->count();

        return view('estudiante.dashboard', compact(
            'proximasCitas', 'totalCitas', 'citasCompletadas',
            'citasPendientes', 'citasCanceladas'
        ));
    }
}
