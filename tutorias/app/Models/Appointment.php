<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'tutor_id',
        'student_id',
        'subject_id',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'notas',
        'notas_tutor',
        'estado',
        'modalidad',
        'ubicacion',
        'motivo_cancelacion',
        'cancelado_en',
        'repeat_weekly',
        'repeat_until',
    ];

    protected $casts = [
        'fecha' => 'date',
        'cancelado_en' => 'datetime',
    ];

    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    public function scopeConfirmadas($query)
    {
        return $query->where('estado', 'confirmada');
    }

    public function scopeCompletadas($query)
    {
        return $query->where('estado', 'completada');
    }

    public function scopeCanceladas($query)
    {
        return $query->where('estado', 'cancelada');
    }

    public function scopeByTutor($query, $tutorId)
    {
        return $query->where('tutor_id', $tutorId);
    }

    public function scopeByStudent($query, $studentId)
    {
        return $query->where('student_id', $studentId);
    }

    public function scopeFechaBetween($query, $start, $end)
    {
        return $query->whereBetween('fecha', [$start, $end]);
    }
}
