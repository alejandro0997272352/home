<?php

namespace App\Exports;

use App\Models\Subject;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SubjectsExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return Subject::select('nombre', 'codigo', 'area', 'creditos', 'activo', 'created_at')
            ->get()
            ->map(fn($s) => [
                $s->nombre,
                $s->codigo ?? '-',
                $s->area ?? '-',
                $s->creditos ?? '-',
                $s->activo ? 'Sí' : 'No',
                $s->created_at->format('d/m/Y H:i'),
            ]);
    }

    public function headings(): array
    {
        return ['Nombre', 'Código', 'Área', 'Créditos', 'Activo', 'Creado'];
    }

    public function styles(Worksheet $sheet)
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}
