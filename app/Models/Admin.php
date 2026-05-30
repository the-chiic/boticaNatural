<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'admin';

    protected $fillable = [
        'name',
        'email',
        'pw',
        'google_auth',
        'phone',
        'rol',
    ];

    protected $hidden = [
        'pw',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'pw' => 'hashed',
        ];
    }

    /**
     * Sobrescribir el nombre del campo de contraseña para usar 'pw' en vez de 'password'
     */
    public function getAuthPasswordName()
    {
        return 'pw';
    }

    /**
     * Sobrescribir el campo de contraseña para usar 'pw' en vez de 'password'
     */
    public function getAuthPassword()
    {
        return $this->pw;
    }

    /**
     * Deshabilitar el token de "recordarme" ya que la tabla no tiene la columna remember_token
     */
    public function getRememberTokenName()
    {
        return '';
    }
}
