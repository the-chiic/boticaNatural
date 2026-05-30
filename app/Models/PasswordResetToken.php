<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PasswordResetToken extends Model
{
    protected $table = 'passwordReset';

    protected $fillable = [
        'user_id',
        'token',
        'expires_at'
    ];

    /**
     * Casting de la fecha de expiración.
     */
    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
        ];
    }

    /**
     * Obtiene el usuario propietario del token.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
