<!DOCTYPE html>
<html>
<head><meta charset="utf-8"></head>
<body style="font-family:sans-serif;padding:20px;">
    <h2 style="color:#059669;">Tutoría Confirmada</h2>
    <p>Hola <strong>{{ $cita->student->name }}</strong>,</p>
    <p>Tu tutoría ha sido confirmada por <strong>{{ $cita->tutor->name }}</strong>.</p>
    <table style="border-collapse:collapse;width:100%;max-width:400px;">
        <tr><td style="padding:6px;color:#666;">Materia:</td><td style="padding:6px;"><strong>{{ $cita->subject->nombre }}</strong></td></tr>
        <tr><td style="padding:6px;color:#666;">Fecha:</td><td style="padding:6px;"><strong>{{ $cita->fecha->format('d/m/Y') }}</strong></td></tr>
        <tr><td style="padding:6px;color:#666;">Horario:</td><td style="padding:6px;"><strong>{{ substr($cita->hora_inicio,0,5) }} - {{ substr($cita->hora_fin,0,5) }}</strong></td></tr>
        <tr><td style="padding:6px;color:#666;">Modalidad:</td><td style="padding:6px;"><strong>{{ ucfirst(str_replace('_',' ',$cita->modalidad)) }}</strong></td></tr>
    </table>
    <p style="margin-top:20px;">No olvides asistir puntualmente a tu tutoría.</p>
</body>
</html>
