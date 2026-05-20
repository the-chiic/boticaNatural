<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    protected $table = 'category';
    
    protected $fillable = [
        'name', 
        'description'
    ];

    /**
     * Los productos que pertenecen a esta categoría.
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_category', 'category_id', 'product_id');
    }

    /**
     * Subcategorías de esta categoría.
     */
    public function subcategories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'subcategory', 'parent_id', 'id');
    }

    /**
     * Categorías padre a las que pertenece esta subcategoría.
     */
    public function parentCategories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'subcategory', 'id', 'parent_id');
    }
}
