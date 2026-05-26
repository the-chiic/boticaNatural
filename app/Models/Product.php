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

    /**
     * Obtiene productos activos con filtros aplicados.
     */
    public static function getFilteredProducts($categories = null, $search = null, $minPrice = null, $maxPrice = null, $sort = null)
    {
        $query = self::with('categories')->where('status', 1);

        // Filtrar por categorías
        if ($categories && is_array($categories) && count($categories) > 0) {
            $query->whereHas('categories', function($q) use ($categories) {
                $q->whereIn('category.id', $categories);
            });
        }

        // Filtrar por búsqueda de texto
        if ($search && $search != '') {
            $query->where('name', 'like', '%' . $search . '%');
        }

        // Filtrar por rango de precio
        if ($minPrice !== null && $minPrice !== '' && $maxPrice !== null && $maxPrice !== '' && $minPrice > $maxPrice) {
            [$minPrice, $maxPrice] = [$maxPrice, $minPrice];
        }

        if ($minPrice !== null && $minPrice !== '') {
            $query->where('price', '>=', $minPrice);
        }

        if ($maxPrice !== null && $maxPrice !== '') {
            $query->where('price', '<=', $maxPrice);
        }

        // Ordenar
        if ($sort && $sort != '') {
            if ($sort === 'price_asc') {
                $query->orderBy('price', 'asc');
            } elseif ($sort === 'price_desc') {
                $query->orderBy('price', 'desc');
            } else {
                $query->orderBy('id', 'desc');
            }
        } else {
            $query->orderBy('id', 'desc');
        }

        return $query;
    }

    /**
     * Obtiene productos destacados aleatorios.
     */
    public static function getFeatured($limit = 4)
    {
        return self::with('categories')
            ->where('status', 1)
            ->inRandomOrder()
            ->take($limit)
            ->get();
    }

    /**
     * Obtiene productos relacionados a un producto específico.
     */
    public static function getRelated($productId, $limit = 4)
    {
        return self::with('categories')
            ->where('status', 1)
            ->where('id', '!=', $productId)
            ->inRandomOrder()
            ->take($limit)
            ->get();
    }

    /**
     * Obtiene un producto activo por ID con sus categorías.
     */
    public static function getActiveById($id)
    {
        return self::with('categories')->where('status', 1)->findOrFail($id);
    }

    /**
     * Obtiene los productos más recientes añadidos a la BBDD.
     */
    public static function getLatest($limit = 4)
    {
        return self::with('categories')
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->take($limit)
            ->get();
    }
}
