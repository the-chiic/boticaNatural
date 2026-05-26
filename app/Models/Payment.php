<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment';

    protected $fillable = [
        'order_id',
        'payment_details',
        'payment_status',
        'reference',
        'amount'
    ];

    /**
     * Relación con el pedido.
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}
