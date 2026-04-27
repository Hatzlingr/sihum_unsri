<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'username',
        'password',
        'role',
        'is_active',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationships
    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class);
    }

    public function pengelola()
    {
        return $this->hasOne(Pengelola::class);
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    // Helper methods
    public function isAdmin()
    {
        return $this->role === 'Admin';
    }

    public function isMahasiswa()
    {
        return $this->role === 'Mahasiswa';
    }

    public function isPengelola()
    {
        return $this->role === 'Pengelola';
    }
}