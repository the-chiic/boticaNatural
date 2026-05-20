<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    protected $table = 'product';
    
    protected $fillable = [
        'promotion_id', 
        'name', 
        'description',
        'status', 
        'price', 
        'stock'
    ];

    /**
     * Las categorías a las que pertenece el producto.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'product_category', 'product_id', 'category_id');
    }
}
