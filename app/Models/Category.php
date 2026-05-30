<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    protected $table = 'category';
    
    protected $fillable = [
        'name', 
        'description',
        'img'
    ];

    protected static function booted()
    {
        static::saved(function ($category) {
            self::clearCategoryCaches();
        });

        static::deleted(function ($category) {
            self::clearCategoryCaches();
        });
    }

    public static function clearCategoryCaches()
    {
        \Cache::forget('categories_ordered');
        \Cache::forget('categories_all');
    }

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

    /**
     * Obtiene todas las categorías ordenadas por nombre.
     */
    public static function getAllOrdered()
    {
        return \Cache::remember('categories_ordered', 3600, function() {
            return self::orderBy('name')->get();
        });
    }

    /**
     * Obtiene todas las categorías sin ordenar.
     */
    public static function getAll()
    {
        return \Cache::remember('categories_all', 3600, function() {
            return self::all();
        });
    }
}
