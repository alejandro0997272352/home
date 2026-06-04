<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Subject;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsuarios = User::count();
        $totalTutores = User::where('role', 'tutor')->count();
        $totalEstudiantes = User::where('role', 'estudiante')->count();
        $totalMaterias = Subject::count();
        $totalCitas = Appointment::count();
        $citasPendientes = Appointment::where('estado', 'pendiente')->count();
        $citasCompletadas = Appointment::where('estado', 'completada')->count();
        $citasCanceladas = Appointment::where('estado', 'cancelada')->count();
        $citasConfirmadas = Appointment::where('estado', 'confirmada')->count();
        $citasHoy = Appointment::whereDate('fecha', today())->count();

        $driver = DB::getDriverName();
        $rawMonth = $driver === 'pgsql' ? "EXTRACT(MONTH FROM created_at)" : "MONTH(created_at)";
        $rawDate = $driver === 'pgsql' ? "fecha::date" : "DATE(fecha)";

        $citasPorMes = Appointment::select(
            DB::raw("{$rawMonth} as mes"),
            DB::raw('COUNT(*) as total')
        )
            ->whereYear('created_at', now()->year)
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $tutoresTop = User::where('role', 'tutor')
            ->withCount(['tutorAppointments as citas_completadas' => function ($q) {
                $q->where('estado', 'completada');
            }])
            ->orderByDesc('citas_completadas')
            ->take(5)
            ->get();

        $citasRecientes = Appointment::with(['tutor', 'student', 'subject'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $citasPorDia = Appointment::select(
            DB::raw("{$rawDate} as dia"),
            DB::raw('COUNT(*) as total')
        )
            ->whereDate('fecha', '>=', now()->subDays(14))
            ->groupBy('dia')
            ->orderBy('dia')
            ->get();

        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

        $usuariosPorRol = [
            ['label' => 'Tutores', 'value' => $totalTutores, 'color' => '#3b82f6'],
            ['label' => 'Estudiantes', 'value' => $totalEstudiantes, 'color' => '#10b981'],
            ['label' => 'Administradores', 'value' => User::where('role', 'admin')->count(), 'color' => '#ef4444'],
        ];

        $estadosCitas = [
            ['label' => 'Pendientes', 'value' => $citasPendientes, 'color' => '#f59e0b'],
            ['label' => 'Confirmadas', 'value' => $citasConfirmadas, 'color' => '#3b82f6'],
            ['label' => 'Completadas', 'value' => $citasCompletadas, 'color' => '#10b981'],
            ['label' => 'Canceladas', 'value' => $citasCanceladas, 'color' => '#ef4444'],
        ];

        return view('admin.dashboard', compact(
            'totalUsuarios', 'totalTutores', 'totalEstudiantes',
            'totalMaterias', 'totalCitas', 'citasPendientes',
            'citasCompletadas', 'citasCanceladas', 'citasConfirmadas',
            'citasHoy', 'citasPorMes', 'tutoresTop',
            'citasRecientes', 'citasPorDia', 'usuariosPorRol', 'estadosCitas', 'meses'
        ));
    }
}
