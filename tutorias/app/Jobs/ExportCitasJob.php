<?php

namespace App\Jobs;

use App\Models\Appointment;
use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportCitasJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    public function __construct(
        public int $userId,
        public string $startDate,
        public string $endDate,
        public ?int $tutorId = null,
        public ?int $subjectId = null,
    ) {}

    public function handle(): void
    {
        $query = Appointment::with(['tutor', 'student', 'subject'])
            ->fechaBetween($this->startDate, $this->endDate);

        if ($this->tutorId) {
            $query->where('tutor_id', $this->tutorId);
        }
        if ($this->subjectId) {
            $query->where('subject_id', $this->subjectId);
        }

        $citas = $query->orderBy('fecha', 'desc')->get();

        $resumen = [
            'total' => $citas->count(),
            'completadas' => $citas->where('estado', 'completada')->count(),
            'pendientes' => $citas->where('estado', 'pendiente')->count(),
            'canceladas' => $citas->where('estado', 'cancelada')->count(),
            'confirmadas' => $citas->where('estado', 'confirmada')->count(),
        ];

        $startDate = $this->startDate;
        $endDate = $this->endDate;

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
        ))->setPaper('a4', 'landscape');

        $filename = "reporte-{$this->startDate}-{$this->endDate}.pdf";
        $path = "exports/{$filename}";
        \Illuminate\Support\Facades\Storage::disk('public')->put($path, $pdf->output());

        Notification::create([
            'user_id' => $this->userId,
            'type' => 'export',
            'title' => 'Exportación completada',
            'message' => "El reporte {$filename} está listo para descargar.",
        ]);
    }
}
