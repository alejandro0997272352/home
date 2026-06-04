<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return User::select('name', 'email', 'role', 'telefono', 'activo', 'created_at')
            ->get()
            ->map(fn($u) => [
                $u->name,
                $u->email,
                $u->role,
                $u->telefono ?? '-',
                $u->activo ? 'Sí' : 'No',
                $u->created_at->format('d/m/Y H:i'),
            ]);
    }

    public function headings(): array
    {
        return ['Nombre', 'Email', 'Rol', 'Teléfono', 'Activo', 'Creado'];
    }

    public function styles(Worksheet $sheet)
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}
