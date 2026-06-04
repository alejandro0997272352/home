<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'telefono',
        'foto_perfil',
        'activo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'activo' => 'boolean',
    ];

    public function tutorProfile()
    {
        return $this->hasOne(TutorProfile::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'tutor_subject')
            ->withPivot('experiencia')
            ->withTimestamps();
    }

    public function availability()
    {
        return $this->hasMany(Availability::class);
    }

    public function tutorAppointments()
    {
        return $this->hasMany(Appointment::class, 'tutor_id');
    }

    public function studentAppointments()
    {
        return $this->hasMany(Appointment::class, 'student_id');
    }

    public function getFotoUrlAttribute(): string
    {
        return $this->foto_perfil
            ? asset('storage/' . $this->foto_perfil)
            : '';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isTutor(): bool
    {
        return $this->role === 'tutor';
    }

    public function isEstudiante(): bool
    {
        return $this->role === 'estudiante';
    }

    public function scopeTutores($query)
    {
        return $query->where('role', 'tutor')->where('activo', true);
    }

    public function scopeEstudiantes($query)
    {
        return $query->where('role', 'estudiante');
    }
}
