<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'pw', 'google_auth', 'phone', 'verification_token', 'password_reset_token', 'password_reset_expires_at'])]
#[Hidden(['pw', 'remember_token'])]
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'user';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'pw' => 'hashed',
        ];
    }

    /**
     * Override the password field name to use 'pw' en vez de 'password'
     */
    public function getAuthPasswordName()
    {
        return 'pw';
    }

    /**
     * Override the password field to use 'pw' en vez de 'password'
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
