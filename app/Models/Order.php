<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'total_price',
        'order_date',
        'status',
        'shipping_name',
        'shipping_address',
        'shipping_city',
        'shipping_post_code',
        'shipping_country',
        'shipping_phone',
        'shipping_method',
        'shipping_cost'
    ];

    /**
     * Relación con las líneas del pedido.
     */
    public function lines()
    {
        return $this->hasMany(OrderLine::class, 'order_id', 'id');
    }

    /**
     * Relación con el pago.
     */
    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id', 'id');
    }

    /**
     * Relación con el usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
