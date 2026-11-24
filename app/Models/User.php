<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public const ROL_ALUMNO = 'alumno';
    public const ROL_PROFESOR = 'profesor';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isProfesor(): bool
    {
        return $this->role === self::ROL_PROFESOR;
    }

    public function isAlumno(): bool
    {
        return $this->role === self::ROL_ALUMNO;
    }

    public function alumno(): HasOne
    {
        return $this->hasOne(Alumno::class);
    }
}
