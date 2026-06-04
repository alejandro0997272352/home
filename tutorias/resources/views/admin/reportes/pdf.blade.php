<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Tutorías</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        h1 { text-align: center; color: #4f46e5; font-size: 22px; margin-bottom: 5px; }
        h2 { color: #4f46e5; font-size: 16px; margin-top: 20px; border-bottom: 2px solid #4f46e5; padding-bottom: 5px; }
        .subtitle { text-align: center; color: #666; font-size: 13px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        th { background: #4f46e5; color: white; padding: 8px; text-align: left; font-size: 11px; }
        td { padding: 7px 8px; border-bottom: 1px solid #ddd; }
        tr:nth-child(even) { background: #f9f9f9; }
        .stats { display: flex; justify-content: space-between; margin: 15px 0; }
        .stat-box { background: #f0f0ff; padding: 10px 15px; border-radius: 8px; text-align: center; flex: 1; margin: 0 5px; }
        .stat-box .num { font-size: 20px; font-weight: bold; color: #4f46e5; }
        .stat-box .label { font-size: 10px; color: #666; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 10px; font-size: 10px; }
        .badge-pendiente { background: #fef3c7; color: #92400e; }
        .badge-confirmada { background: #dbeafe; color: #1e40af; }
        .badge-completada { background: #d1fae5; color: #065f46; }
        .badge-cancelada { background: #fee2e2; color: #991b1b; }
        .footer { text-align: center; color: #999; font-size: 10px; margin-top: 30px; border-top: 1px solid #ddd; padding-top: 10px; }
    </style>
</head>
<body>
    <h1>Sistema de Tutorías Académicas</h1>
    <p class="subtitle">Reporte del {{ $startDate }} al {{ $endDate }}</p>

    <div class="stats">
        <div class="stat-box"><div class="num">{{ $resumen['total'] }}</div><div class="label">Total</div></div>
        <div class="stat-box"><div class="num">{{ $resumen['pendientes'] }}</div><div class="label">Pendientes</div></div>
        <div class="stat-box"><div class="num">{{ $resumen['confirmadas'] }}</div><div class="label">Confirmadas</div></div>
        <div class="stat-box"><div class="num">{{ $resumen['completadas'] }}</div><div class="label">Completadas</div></div>
        <div class="stat-box"><div class="num">{{ $resumen['canceladas'] }}</div><div class="label">Canceladas</div></div>
    </div>

    <h2>Citas por Tutor</h2>
    <table>
        <thead><tr><th>Tutor</th><th>Citas</th></tr></thead>
        <tbody>
            @foreach($citasPorTutor as $item)
                <tr><td>{{ $item->tutor->name ?? 'N/A' }}</td><td>{{ $item->total }}</td></tr>
            @endforeach
            @if($citasPorTutor->isEmpty())
                <tr><td colspan="2" style="text-align:center;color:#999;">Sin datos</td></tr>
            @endif
        </tbody>
    </table>

    <h2>Citas por Materia</h2>
    <table>
        <thead><tr><th>Materia</th><th>Citas</th></tr></thead>
        <tbody>
            @foreach($citasPorMateria as $item)
                <tr><td>{{ $item->subject->nombre ?? 'N/A' }}</td><td>{{ $item->total }}</td></tr>
            @endforeach
            @if($citasPorMateria->isEmpty())
                <tr><td colspan="2" style="text-align:center;color:#999;">Sin datos</td></tr>
            @endif
        </tbody>
    </table>

    <h2>Detalle de Citas</h2>
    <table>
        <thead><tr><th>Fecha</th><th>Tutor</th><th>Estudiante</th><th>Materia</th><th>Estado</th></tr></thead>
        <tbody>
            @foreach($citas as $cita)
                <tr>
                    <td>{{ $cita->fecha->format('d/m/Y') }} {{ substr($cita->hora_inicio, 0, 5) }}</td>
                    <td>{{ $cita->tutor->name }}</td>
                    <td>{{ $cita->student->name }}</td>
                    <td>{{ $cita->subject->nombre }}</td>
                    <td><span class="badge badge-{{ $cita->estado }}">{{ ucfirst($cita->estado) }}</span></td>
                </tr>
            @endforeach
            @if($citas->isEmpty())
                <tr><td colspan="5" style="text-align:center;color:#999;">No hay citas en este período</td></tr>
            @endif
        </tbody>
    </table>

    <div class="footer">
        Generado el {{ now()->format('d/m/Y H:i') }} &mdash; Sistema de Tutorías Académicas
    </div>
</body>
</html>
