<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><style>
body { font-family: sans-serif; background: #f4f4f4; padding: 20px; }
.container { max-width: 480px; margin: auto; background: white; border-radius: 12px; padding: 24px; }
h1 { font-size: 18px; color: #333; }
p { color: #666; line-height: 1.5; }
.info { background: #f0f4ff; border-radius: 8px; padding: 12px; margin: 12px 0; }
.info strong { color: #333; }
.cta { display: inline-block; background: #4f46e5; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; margin-top: 12px; }
</style></head>
<body>
<div class="container">
    <h1>📚 Recordatorio de Tutoría</h1>
    <p>Hola <strong>{{ $appointment->student->name }}</strong>,</p>
    <p>Tu tutoría con <strong>{{ $appointment->tutor->name }}</strong> está agendada para mañana.</p>
    <div class="info">
        <p><strong>Materia:</strong> {{ $appointment->subject->nombre }}</p>
        <p><strong>Fecha:</strong> {{ $appointment->fecha->format('d/m/Y') }}</p>
        <p><strong>Horario:</strong> {{ substr($appointment->hora_inicio, 0, 5) }} - {{ substr($appointment->hora_fin, 0, 5) }}</p>
    </div>
    <p>No olvides asistir puntualmente. ¡Nos vemos!</p>
    <p style="color:#999;font-size:12px;margin-top:16px;">Este es un mensaje automático, por favor no respondas a este correo.</p>
</div>
</body>
</html>
