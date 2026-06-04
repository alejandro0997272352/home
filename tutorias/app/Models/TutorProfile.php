<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'biografia',
        'formacion_academica',
        'calificacion_promedio',
        'total_sesiones',
        'tarifa_por_hora',
    ];

    protected $casts = [
        'calificacion_promedio' => 'decimal:2',
        'total_sesiones' => 'integer',
        'tarifa_por_hora' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function syncStats(): void
    {
        $completadas = $this->user->tutorAppointments()->where('estado', 'completada');
        $total = (clone $completadas)->count();

        $avg = (clone $completadas)
            ->whereHas('review')
            ->join('reviews', 'appointments.id', '=', 'reviews.appointment_id')
            ->avg('reviews.calificacion');

        $this->update([
            'total_sesiones' => $total,
            'calificacion_promedio' => round($avg ?? 0, 2),
        ]);
    }
}
