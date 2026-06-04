<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Subject;
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
        $tutorId = $request->get('tutor_id');
        $subjectId = $request->get('subject_id');

        $query = Appointment::with(['tutor', 'student', 'subject'])
            ->fechaBetween($startDate, $endDate);

        if ($tutorId) {
            $query->where('tutor_id', $tutorId);
        }
        if ($subjectId) {
            $query->where('subject_id', $subjectId);
        }

        $citas = $query->orderBy('fecha', 'desc')->get();

        $resumen = [
            'total' => $citas->count(),
            'completadas' => $citas->where('estado', 'completada')->count(),
            'pendientes' => $citas->where('estado', 'pendiente')->count(),
            'canceladas' => $citas->where('estado', 'cancelada')->count(),
            'confirmadas' => $citas->where('estado', 'confirmada')->count(),
        ];

        $tutores = User::where('role', 'tutor')->orderBy('name')->get();
        $materias = Subject::orderBy('nombre')->get();

        return view('admin.reportes.index', compact(
            'citas', 'resumen', 'startDate', 'endDate',
            'tutores', 'materias', 'tutorId', 'subjectId'
        ));
    }

    public function exportPdf(Request $request)
    {
        $startDate = $request->get('fecha_inicio', now()->startOfMonth()->toDateString());
        $endDate = $request->get('fecha_fin', now()->endOfMonth()->toDateString());
        $tutorId = $request->get('tutor_id');
        $subjectId = $request->get('subject_id');

        $query = Appointment::with(['tutor', 'student', 'subject'])
            ->fechaBetween($startDate, $endDate);

        if ($tutorId) {
            $query->where('tutor_id', $tutorId);
        }
        if ($subjectId) {
            $query->where('subject_id', $subjectId);
        }

        $citas = $query->orderBy('fecha', 'desc')->get();

        $resumen = [
            'total' => $citas->count(),
            'completadas' => $citas->where('estado', 'completada')->count(),
            'pendientes' => $citas->where('estado', 'pendiente')->count(),
            'canceladas' => $citas->where('estado', 'cancelada')->count(),
            'confirmadas' => $citas->where('estado', 'confirmada')->count(),
        ];

        $citasPorTutor = $citas->groupBy('tutor_id')->map(function ($group) {
            return (object) [
                'tutor' => $group->first()->tutor,
                'total' => $group->count(),
            ];
        })->values();

        $citasPorMateria = $citas->groupBy('subject_id')->map(function ($group) {
            return (object) [
                'subject' => $group->first()->subject,
                'total' => $group->count(),
            ];
        })->values();

        $pdf = Pdf::loadView('admin.reportes.pdf', compact(
            'citas', 'resumen', 'startDate', 'endDate', 'citasPorTutor', 'citasPorMateria'
        ));

        return $pdf->download("reporte-tutorias-{$startDate}-{$endDate}.pdf");
    }
}
