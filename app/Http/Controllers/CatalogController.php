<?php

namespace App\Http\Controllers;

use App\Http\Requests\CatalogFilterRequest;
use App\Models\Category;
use App\Models\Product;

class CatalogController extends Controller
{
    /**
     * Obtiene todas las categorías ordenadas.
     */
    public function getCategories()
    {
        return Category::getAllOrdered();
    }

    /**
     * Obtiene productos filtrados según los parámetros.
     */
    public function getFilteredProducts(CatalogFilterRequest $request)
    {
        $categories = $request->input('categories');
        $search = $request->input('search');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $sort = $request->input('sort');

        $query = Product::getFilteredProducts($categories, $search, $minPrice, $maxPrice, $sort);
        
        return $query->paginate(12);
    }

    /**
     * Renderiza los resultados del catálogo para peticiones AJAX.
     */
    public function renderCatalogResults($products)
    {
        return view('catalog.partials.results', compact('products'))->render();
    }

    /**
     * Muestra el catálogo de productos con sus categorías.
     */
    public function index(CatalogFilterRequest $request)
    {
        $categories = $this->getCategories();
        $products = $this->getFilteredProducts($request);

        if ($request->ajax()) {
            return $this->renderCatalogResults($products);
        }
        
        return view('catalog.index', compact('products', 'categories'));
    }

    /**
     * Obtiene un producto activo por ID.
     */
    public function getProductById($id)
    {
        return Product::getActiveById($id);
    }

    /**
     * Obtiene productos relacionados a un producto específico.
     */
    public function getRelatedProducts($productId)
    {
        return Product::getRelated($productId, 4);
    }

    /**
     * Muestra el detalle de un producto específico.
     */
    public function show($id)
    {
        $product = $this->getProductById($id);
        $relatedProducts = $this->getRelatedProducts($id);
        
        return view('catalog.show', compact('product', 'relatedProducts'));
    }

    /**
     * Resuelve las URLs de fondo para las categorías según su nombre.
     */
    public function resolveCategoriesForDisplay($categories)
    {
        $resolvedCategories = [];
        foreach ($categories as $category) {
            $nameLower = mb_strtolower($category->name);
            $bgUrl = 'https://images.unsplash.com/photo-1465146344425-f00d5f5c8f07?q=80&w=800&auto=format&fit=crop'; // default
            
            $hasCustomImg = false;
            if (!empty($category->img)) {
                if (str_starts_with($category->img, 'http://') || str_starts_with($category->img, 'https://')) {
                    $bgUrl = $category->img;
                    $hasCustomImg = true;
                } elseif (file_exists(public_path($category->img))) {
                    $bgUrl = asset($category->img);
                    $hasCustomImg = true;
                } elseif (file_exists(public_path('img/' . $category->img))) {
                    $bgUrl = asset('img/' . $category->img);
                    $hasCustomImg = true;
                } elseif (file_exists(public_path('storage/' . $category->img))) {
                    $bgUrl = asset('storage/' . $category->img);
                    $hasCustomImg = true;
                }
            }
            
            if (!$hasCustomImg) {
                if (str_contains($nameLower, 'infusion') || str_contains($nameLower, 'té') || str_contains($nameLower, 'te')) {
                    $bgUrl = 'https://images.unsplash.com/photo-1576092762791-dd9e2220d960?q=80&w=800&auto=format&fit=crop';
                } elseif (str_contains($nameLower, 'aceite')) {
                    $bgUrl = 'https://images.unsplash.com/photo-1608248543803-ba4f8c70ae0b?q=80&w=800&auto=format&fit=crop';
                } elseif (str_contains($nameLower, 'cosmet') || str_contains($nameLower, 'cosmét')) {
                    $bgUrl = 'https://images.unsplash.com/photo-1556228573-7303e8707198?q=80&w=800&auto=format&fit=crop';
                } elseif (str_contains($nameLower, 'medic')) {
                    $bgUrl = 'https://images.unsplash.com/photo-1471864190281-a93a3070b6de?q=80&w=800&auto=format&fit=crop';
                } elseif (str_contains($nameLower, 'herbol') || str_contains($nameLower, 'plant') || str_contains($nameLower, 'natural')) {
                    $bgUrl = 'https://images.unsplash.com/photo-1515694346937-94d85e41e6f0?q=80&w=800&auto=format&fit=crop';
                }
            }
            
            $resolvedCategories[] = [
                'id' => $category->id,
                'name' => $category->name,
                'description' => $category->description ?? 'Descubre nuestra selección de ' . $category->name,
                'bgUrl' => $bgUrl
            ];
        }

        return $resolvedCategories;
    }

    /**
     * Obtiene las categorías para display en el home, duplicando si es necesario.
     */
    public function getDisplayCategories($resolvedCategories)
    {
        $displayCategories = $resolvedCategories;
        if (count($resolvedCategories) > 0 && count($resolvedCategories) < 6) {
            $displayCategories = array_merge($resolvedCategories, $resolvedCategories);
            if (count($displayCategories) < 6) {
                $displayCategories = array_merge($displayCategories, $resolvedCategories);
            }
        }
        return $displayCategories;
    }

    /**
     * Obtiene los productos destacados.
     */
    public function getFeaturedProducts()
    {
        return Product::getFeatured(4);
    }

    /**
     * Obtiene los productos más recientes añadidos a la BBDD.
     */
    public function getLatestProducts()
    {
        return Product::getLatest(4);
    }

    /**
     * Obtiene productos relacionados aleatorios para el home.
     */
    public function getRelatedProductsForHome()
    {
        return Product::getRelated(0, 4);
    }

    /**
     * Muestra la página principal (Home) con categorías resueltas y productos recientes.
     */
    public function home()
    {
        $categories = Category::getAll();
        $resolvedCategories = $this->resolveCategoriesForDisplay($categories);
        $displayCategories = $this->getDisplayCategories($resolvedCategories);
        $latestProducts = $this->getLatestProducts();

        return view('home.index', compact('displayCategories', 'latestProducts'));
    }
}
