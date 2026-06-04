<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'user_id',
        'calificacion',
        'comentario',
        'aprobado',
        'moderated_at',
        'moderated_by',
    ];

    protected $casts = [
        'calificacion' => 'integer',
        'aprobado' => 'boolean',
        'moderated_at' => 'datetime',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
