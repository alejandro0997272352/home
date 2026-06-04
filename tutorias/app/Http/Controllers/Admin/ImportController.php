<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function index()
    {
        return view('admin.materias.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'archivo' => 'required|file|mimes:csv,xlsx,xls|max:2048',
        ]);

        $importados = 0;
        $errores = [];

        if ($request->file('archivo')->extension() === 'csv') {
            $handle = fopen($request->file('archivo')->path(), 'r');
            $headers = fgetcsv($handle);

            $row = 1;
            while (($data = fgetcsv($handle)) !== false) {
                $row++;
                try {
                    $rowData = array_combine($headers, $data);
                    Subject::create([
                        'nombre' => $rowData['nombre'] ?? $rowData[0],
                        'codigo' => $rowData['codigo'] ?? ($rowData[1] ?? null),
                        'area' => $rowData['area'] ?? ($rowData[2] ?? null),
                        'creditos' => $rowData['creditos'] ?? ($rowData[3] ?? null),
                        'descripcion' => $rowData['descripcion'] ?? ($rowData[4] ?? null),
                        'activo' => true,
                    ]);
                    $importados++;
                } catch (\Exception $e) {
                    $errores[] = "Fila {$row}: " . $e->getMessage();
                }
            }
            fclose($handle);
        } else {
            try {
                $data = Excel::toArray([], $request->file('archivo'));
                $rows = $data[0] ?? [];
                $headers = array_shift($rows);

                foreach ($rows as $i => $row) {
                    try {
                        $rowData = array_combine($headers, $row);
                        Subject::create([
                            'nombre' => $rowData['nombre'] ?? ($row[0] ?? ''),
                            'codigo' => $rowData['codigo'] ?? ($row[1] ?? null),
                            'area' => $rowData['area'] ?? ($row[2] ?? null),
                            'creditos' => $rowData['creditos'] ?? ($row[3] ?? null),
                            'descripcion' => $rowData['descripcion'] ?? ($row[4] ?? null),
                            'activo' => true,
                        ]);
                        $importados++;
                    } catch (\Exception $e) {
                        $errores[] = "Fila " . ($i + 2) . ": " . $e->getMessage();
                    }
                }
            } catch (\Exception $e) {
                return back()->with('error', 'Error al procesar el archivo: ' . $e->getMessage());
            }
        }

        if ($importados > 0) {
            return redirect()->route('admin.materias.index')
                ->with('success', "{$importados} materia(s) importada(s) correctamente." . (!empty($errores) ? ' (' . count($errores) . ' error(es))' : ''));
        }

        return back()->with('error', 'No se pudo importar ninguna materia. Verifica el formato del archivo.');
    }
}
