<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'address';

    protected $fillable = [
        'user_id',
        'address',
        'province',
        'city',
        'post_code',
        'country',
        'phone',
        'name_destination'
    ];

    /**
     * Obtiene todas las direcciones de un usuario específico.
     */
    public static function getByUserId(int $userId)
    {
        return self::where('user_id', $userId)->get();
    }
}
