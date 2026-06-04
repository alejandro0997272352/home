<!DOCTYPE html>
<html>
<head><meta charset="utf-8"></head>
<body style="font-family:sans-serif;padding:20px;">
    <h2 style="color:#dc2626;">Tutoría Cancelada</h2>
    <p>Hola <strong>{{ $cita->student->name }}</strong>,</p>
    <p>Lamentamos informarte que la siguiente tutoría ha sido cancelada:</p>
    <table style="border-collapse:collapse;width:100%;max-width:400px;">
        <tr><td style="padding:6px;color:#666;">Tutor:</td><td style="padding:6px;"><strong>{{ $cita->tutor->name }}</strong></td></tr>
        <tr><td style="padding:6px;color:#666;">Materia:</td><td style="padding:6px;"><strong>{{ $cita->subject->nombre }}</strong></td></tr>
        <tr><td style="padding:6px;color:#666;">Fecha:</td><td style="padding:6px;"><strong>{{ $cita->fecha->format('d/m/Y') }}</strong></td></tr>
        <tr><td style="padding:6px;color:#666;">Horario:</td><td style="padding:6px;"><strong>{{ substr($cita->hora_inicio,0,5) }} - {{ substr($cita->hora_fin,0,5) }}</strong></td></tr>
    </table>
    @if($cita->motivo_cancelacion)
        <p style="margin-top:10px;padding:10px;background:#fee2e2;border-radius:5px;color:#991b1b;">
            <strong>Motivo:</strong> {{ $cita->motivo_cancelacion }}
        </p>
    @endif
    <p style="margin-top:20px;">Puedes agendar una nueva tutoría desde el sistema.</p>
</body>
</html>
