<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Zorg dat dit ook in fillable staat
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

    // 🔑 Relatie naar Student
    public function student()
    {
        return $this->hasOne(Student::class);
    }

    // 🔑 Relatie naar Teacher
    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    /**
     * ✅ Alleen admins mogen inloggen op het Filament admin panel
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->role === 'admin';
    }
}
