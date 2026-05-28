<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderLine extends Model
{
    protected $table = 'order_line';

    // Deshabilitar timestamps ya que la tabla original no los tiene
    public $timestamps = false;

    // Deshabilitar incrementos automáticos y clave única numérica simple
    public $incrementing = false;
    protected $primaryKey = 'order_id'; // Clave compuesta simulada

    protected $fillable = [
        'order_id',
        'num_line',
        'product_id',
        'unit',
        'price',
        'total_price'
    ];

    /**
     * Relación con el pedido.
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    /**
     * Relación con el producto.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
