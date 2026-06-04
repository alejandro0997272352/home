<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'tutor_id', 'last_message_at'];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function lastMessage()
    {
        return $this->hasOne(Message::class)->latest();
    }

    public function unreadCount(int $userId)
    {
        return $this->messages()->where('sender_id', '!=', $userId)->where('read', false)->count();
    }

    public function scopeForUser($query, int $userId)
    {
        return $query->where('student_id', $userId)->orWhere('tutor_id', $userId);
    }

    public function otherUser(int $userId)
    {
        return $this->student_id === $userId ? $this->tutor : $this->student;
    }
}
