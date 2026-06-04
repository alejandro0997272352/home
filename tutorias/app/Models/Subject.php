<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'codigo',
        'descripcion',
        'area',
        'creditos',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'creditos' => 'integer',
    ];

    public function tutors()
    {
        return $this->belongsToMany(User::class, 'tutor_subject')
            ->withPivot('experiencia')
            ->withTimestamps();
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function scopeActivas($query)
    {
        return $query->where('activo', true);
    }
}
