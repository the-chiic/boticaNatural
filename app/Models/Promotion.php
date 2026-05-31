<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $table = 'promotion';
    
    protected $fillable = [
        'name',
        'code',
        'discount',
        'is_active',
        'show_on_web',
        'starts_at',
        'ends_at'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'show_on_web' => 'boolean',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'discount' => 'decimal:2',
    ];
}
