<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->get('fecha_inicio', now()->startOfMonth()->toDateString());
        $endDate = $request->get('fecha_fin', now()->endOfMonth()->toDateString());

        $citas = Appointment::with(['tutor', 'student', 'subject'])
            ->fechaBetween($startDate, $endDate)
            ->orderBy('fecha', 'desc')
            ->get();

        $resumen = [
            'total' => $citas->count(),
            'completadas' => $citas->where('estado', 'completada')->count(),
            'pendientes' => $citas->where('estado', 'pendiente')->count(),
            'canceladas' => $citas->where('estado', 'cancelada')->count(),
            'confirmadas' => $citas->where('estado', 'confirmada')->count(),
        ];

        $citasPorTutor = Appointment::select('tutor_id', DB::raw('count(*) as total'))
            ->fechaBetween($startDate, $endDate)
            ->groupBy('tutor_id')
            ->with('tutor')
            ->get();

        $citasPorMateria = Appointment::select('subject_id', DB::raw('count(*) as total'))
            ->fechaBetween($startDate, $endDate)
            ->groupBy('subject_id')
            ->with('subject')
            ->get();

        return view('admin.reportes.index', compact(
            'citas', 'resumen', 'citasPorTutor', 'citasPorMateria',
            'startDate', 'endDate'
        ));
    }

    public function exportPdf(Request $request)
    {
        $startDate = $request->get('fecha_inicio', now()->startOfMonth()->toDateString());
        $endDate = $request->get('fecha_fin', now()->endOfMonth()->toDateString());

        $citas = Appointment::with(['tutor', 'student', 'subject'])
            ->fechaBetween($startDate, $endDate)
            ->orderBy('fecha', 'desc')
            ->get();

        $resumen = [
            'total' => $citas->count(),
            'completadas' => $citas->where('estado', 'completada')->count(),
            'pendientes' => $citas->where('estado', 'pendiente')->count(),
            'canceladas' => $citas->where('estado', 'cancelada')->count(),
            'confirmadas' => $citas->where('estado', 'confirmada')->count(),
        ];

        $citasPorTutor = Appointment::select('tutor_id', DB::raw('count(*) as total'))
            ->fechaBetween($startDate, $endDate)
            ->groupBy('tutor_id')
            ->with('tutor')
            ->get();

        $citasPorMateria = Appointment::select('subject_id', DB::raw('count(*) as total'))
            ->fechaBetween($startDate, $endDate)
            ->groupBy('subject_id')
            ->with('subject')
            ->get();

        $pdf = Pdf::loadView('admin.reportes.pdf', compact(
            'citas', 'resumen', 'citasPorTutor', 'citasPorMateria',
            'startDate', 'endDate'
        ));

        return $pdf->download("reporte-tutorias-{$startDate}-{$endDate}.pdf");
    }
}
