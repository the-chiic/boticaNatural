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

    protected static $productImagesCache = null;

    protected static function booted()
    {
        static::saved(function ($product) {
            self::clearProductCaches();
        });

        static::deleted(function ($product) {
            self::clearProductCaches();
        });
    }

    public static function clearProductCaches()
    {
        \Cache::forget('featured_products_4');
        \Cache::forget('latest_products_4');
    }

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
        return \Cache::remember('featured_products_' . $limit, 600, function() use ($limit) {
            return self::with('categories')
                ->where('status', 1)
                ->inRandomOrder()
                ->take($limit)
                ->get();
        });
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
        return \Cache::remember('latest_products_' . $limit, 600, function() use ($limit) {
            return self::with('categories')
                ->where('status', 1)
                ->orderBy('id', 'desc')
                ->take($limit)
                ->get();
        });
    }

    /**
     * Accesor para obtener la URL de imagen premium del producto (archivo local o fallback de Unsplash).
     */
    public function getImageUrlAttribute()
    {
        if (self::$productImagesCache === null) {
            self::$productImagesCache = \DB::table('product_img')->pluck('name', 'id')->all();
        }
        
        $imgName = self::$productImagesCache[$this->img_id] ?? null;
        
        if ($imgName) {
            if (str_starts_with($imgName, 'http://') || str_starts_with($imgName, 'https://')) {
                return $imgName;
            }
            
            // Si el archivo físico existe localmente en public/storage o public/img
            if (file_exists(public_path('storage/' . $imgName))) {
                return asset('storage/' . $imgName);
            }
            if (file_exists(public_path('img/' . $imgName))) {
                return asset('img/' . $imgName);
            }
        }

        // Mapeo dinámico y elegante de imágenes Unsplash de alta calidad y resolución
        $name = mb_strtolower($this->name);
        
        if (str_contains($name, 'paracetamol')) {
            return 'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?q=80&w=600&auto=format&fit=crop';
        }
        if (str_contains($name, 'ibuprofeno')) {
            return 'https://images.unsplash.com/photo-1603398938378-e54eab446dde?q=80&w=600&auto=format&fit=crop';
        }
        if (str_contains($name, 'hiedra') || str_contains($name, 'jarabe')) {
            return 'https://images.unsplash.com/photo-1550572017-edd951b55104?q=80&w=600&auto=format&fit=crop';
        }
        if (str_contains($name, 'árnica') || str_contains($name, 'arnica')) {
            return 'https://images.unsplash.com/photo-1502741338009-cac2772e18bc?q=80&w=600&auto=format&fit=crop';
        }
        if (str_contains($name, 'miel') || str_contains($name, 'limón') || str_contains($name, 'limon')) {
            return 'https://images.unsplash.com/photo-1587049352846-4a222e784d38?q=80&w=600&auto=format&fit=crop';
        }
        if (str_contains($name, 'romero')) {
            return 'https://images.unsplash.com/photo-1527661591475-527312dd65f5?q=80&w=600&auto=format&fit=crop';
        }
        if (str_contains($name, 'mar spray') || str_contains($name, 'nasal')) {
            return 'https://images.unsplash.com/photo-1563483783225-bf568b209e99?q=80&w=600&auto=format&fit=crop';
        }
        if (str_contains($name, 'carbón') || str_contains($name, 'carbon')) {
            return 'https://images.unsplash.com/photo-1564419320461-6870880221ad?q=80&w=600&auto=format&fit=crop';
        }
        if (str_contains($name, 'tigre')) {
            return 'https://images.unsplash.com/photo-1512290923902-8a9f81dc236c?q=80&w=600&auto=format&fit=crop';
        }
        if (str_contains($name, 'aloe')) {
            return 'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?q=80&w=600&auto=format&fit=crop';
        }
        if (str_contains($name, 'rosa mosqueta') || str_contains($name, 'rosa')) {
            return 'https://images.unsplash.com/photo-1515694346937-94d85e41e6f0?q=80&w=600&auto=format&fit=crop';
        }
        if (str_contains($name, 'biotina') || str_contains($name, 'champú') || str_contains($name, 'champu')) {
            return 'https://images.unsplash.com/photo-1535585209827-a15fcdbc4c2d?q=80&w=600&auto=format&fit=crop';
        }
        if (str_contains($name, 'contorno')) {
            return 'https://images.unsplash.com/photo-1620916566398-39f1143ab7be?q=80&w=600&auto=format&fit=crop';
        }
        if (str_contains($name, 'arcilla')) {
            return 'https://images.unsplash.com/photo-1598440947619-2c35fc9aa908?q=80&w=600&auto=format&fit=crop';
        }
        if (str_contains($name, 'solar')) {
            return 'https://images.unsplash.com/photo-1526947425960-945c6e72858f?q=80&w=600&auto=format&fit=crop';
        }
        if (str_contains($name, 'árbol de té') || str_contains($name, 'arbol de te')) {
            return 'https://images.unsplash.com/photo-1611080626919-7cf5a9dbab5b?q=80&w=600&auto=format&fit=crop';
        }
        if (str_contains($name, 'karité') || str_contains($name, 'labial')) {
            return 'https://images.unsplash.com/photo-1617897903246-719242758050?q=80&w=600&auto=format&fit=crop';
        }
        if (str_contains($name, 'manos') || str_contains($name, 'caléndula') || str_contains($name, 'calendula')) {
            return 'https://images.unsplash.com/photo-1608248597279-f99d160bfcbc?q=80&w=600&auto=format&fit=crop';
        }
        if (str_contains($name, 'exfoliante') || str_contains($name, 'café') || str_contains($name, 'cafe')) {
            return 'https://images.unsplash.com/photo-1601049676099-e7ed07d825b0?q=80&w=600&auto=format&fit=crop';
        }
        if (str_contains($name, 'vitamina c') || str_contains($name, 'vitamina')) {
            return 'https://images.unsplash.com/photo-1616679911721-fe6eec10fcd5?q=80&w=600&auto=format&fit=crop';
        }
        if (str_contains($name, 'jabón') || str_contains($name, 'jabon')) {
            return 'https://images.unsplash.com/photo-1546554137-f86b9593a222?q=80&w=600&auto=format&fit=crop';
        }
        if (str_contains($name, 'valeriana') || str_contains($name, 'tila')) {
            return 'https://images.unsplash.com/photo-1576092762791-dd9e2220d960?q=80&w=600&auto=format&fit=crop';
        }
        if (str_contains($name, 'cúrcuma') || str_contains($name, 'curcuma')) {
            return 'https://images.unsplash.com/photo-1615485290382-441e4d049cb5?q=80&w=600&auto=format&fit=crop';
        }
        if (str_contains($name, 'jalea')) {
            return 'https://images.unsplash.com/photo-1587049352851-8d4e89134292?q=80&w=600&auto=format&fit=crop';
        }
        if (str_contains($name, 'colágeno') || str_contains($name, 'colageno')) {
            return 'https://images.unsplash.com/photo-1628771065518-0d82f1938462?q=80&w=600&auto=format&fit=crop';
        }
        if (str_contains($name, 'própolis') || str_contains($name, 'propolis')) {
            return 'https://images.unsplash.com/photo-1626202378250-963544d6d45e?q=80&w=600&auto=format&fit=crop';
        }
        if (str_contains($name, 'espirulina')) {
            return 'https://images.unsplash.com/photo-1611244419377-b0a760c19719?q=80&w=600&auto=format&fit=crop';
        }
        if (str_contains($name, 'manzanilla')) {
            return 'https://images.unsplash.com/photo-1515694346937-94d85e41e6f0?q=80&w=600&auto=format&fit=crop';
        }
        if (str_contains($name, 'melatonina')) {
            return 'https://images.unsplash.com/photo-1512290923902-8a9f81dc236c?q=80&w=600&auto=format&fit=crop';
        }
        if (str_contains($name, 'ginkgo')) {
            return 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=600&auto=format&fit=crop';
        }
        if (str_contains($name, 'levadura')) {
            return 'https://images.unsplash.com/photo-1584017911766-d451b3d0e843?q=80&w=600&auto=format&fit=crop';
        }

        // Aceites (general)
        if (str_contains($name, 'aceite')) {
            return 'https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?q=80&w=600&auto=format&fit=crop';
        }

        return asset('img/imgPrueba.png');
    }

    /**
     * Accesor para obtener una galería de varias imágenes de alta calidad (carrusel) para el producto.
     */
    public function getGalleryImagesAttribute()
    {
        $mainImage = $this->image_url;
        
        // Generar un conjunto de 3 imágenes premium adicionales para el carrusel de forma inteligente
        $name = mb_strtolower($this->name);
        $additional = [];
        
        if (str_contains($name, 'paracetamol') || str_contains($name, 'ibuprofeno') || str_contains($name, 'pastillas') || str_contains($name, 'suplemento') || str_contains($name, 'vitamina') || str_contains($name, 'colágeno') || str_contains($name, 'espirulina')) {
            $additional = [
                'https://images.unsplash.com/photo-1471864190281-a93a3070b6de?q=80&w=600&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1584017911766-d451b3d0e843?q=80&w=600&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1628771065518-0d82f1938462?q=80&w=600&auto=format&fit=crop'
            ];
        } elseif (str_contains($name, 'aceite')) {
            $additional = [
                'https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?q=80&w=600&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1527661591475-527312dd65f5?q=80&w=600&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1617897903246-719242758050?q=80&w=600&auto=format&fit=crop'
            ];
        } elseif (str_contains($name, 'crema') || str_contains($name, 'aloe') || str_contains($name, 'contorno') || str_contains($name, 'mascarilla') || str_contains($name, 'solar') || str_contains($name, 'manos') || str_contains($name, 'exfoliante') || str_contains($name, 'jabón') || str_contains($name, 'jabon')) {
            $additional = [
                'https://images.unsplash.com/photo-1620916566398-39f1143ab7be?q=80&w=600&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?q=80&w=600&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1598440947619-2c35fc9aa908?q=80&w=600&auto=format&fit=crop'
            ];
        } elseif (str_contains($name, 'infusión') || str_contains($name, 'infusion') || str_contains($name, 'té') || str_contains($name, 'te') || str_contains($name, 'valeriana') || str_contains($name, 'tila') || str_contains($name, 'manzanilla')) {
            $additional = [
                'https://images.unsplash.com/photo-1576092762791-dd9e2220d960?q=80&w=600&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1597481499750-3e6b22637e12?q=80&w=600&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1544787219-7f47ccb76574?q=80&w=600&auto=format&fit=crop'
            ];
        } else {
            $additional = [
                'https://images.unsplash.com/photo-1512290923902-8a9f81dc236c?q=80&w=600&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1515694346937-94d85e41e6f0?q=80&w=600&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1608248597279-f99d160bfcbc?q=80&w=600&auto=format&fit=crop'
            ];
        }
        
        return array_merge([$mainImage], $additional);
    }
}
