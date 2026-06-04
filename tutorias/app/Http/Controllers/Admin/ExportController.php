<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\UsersExport;
use App\Exports\SubjectsExport;
use App\Exports\AppointmentsExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function users()
    {
        return Excel::download(new UsersExport, 'usuarios.xlsx');
    }

    public function subjects()
    {
        return Excel::download(new SubjectsExport, 'materias.xlsx');
    }

    public function appointments()
    {
        return Excel::download(new AppointmentsExport, 'citas.xlsx');
    }
}
