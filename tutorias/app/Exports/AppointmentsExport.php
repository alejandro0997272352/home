<?php

namespace App\Exports;

use App\Models\Appointment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AppointmentsExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return Appointment::with(['tutor', 'student', 'subject'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn($c) => [
                $c->tutor->name ?? '-',
                $c->student->name ?? '-',
                $c->subject->nombre ?? '-',
                $c->fecha->format('d/m/Y'),
                substr($c->hora_inicio, 0, 5) . ' - ' . substr($c->hora_fin, 0, 5),
                $c->estado,
                $c->modalidad ?? '-',
                $c->created_at->format('d/m/Y H:i'),
            ]);
    }

    public function headings(): array
    {
        return ['Tutor', 'Estudiante', 'Materia', 'Fecha', 'Horario', 'Estado', 'Modalidad', 'Creado'];
    }

    public function styles(Worksheet $sheet)
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}
