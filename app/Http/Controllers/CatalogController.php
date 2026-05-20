<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    /**
     * Muestra el catálogo de productos con sus categorías.
     */
    public function index(Request $request)
    {
        // Obtenemos todas las categorías
        $categories = Category::orderBy('name')->get();
        
        // Iniciamos la consulta de productos activos
        $query = Product::with('categories')->where('status', 1);
        
        // Filtramos por categorías si se seleccionaron
        if ($request->has('categories') && is_array($request->categories) && count($request->categories) > 0) {
            $query->whereHas('categories', function($q) use ($request) {
                $q->whereIn('category.id', $request->categories);
            });
        }

        // Filtramos por búsqueda de texto
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filtramos por rango de precio
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        if ($minPrice !== null && $minPrice !== '' && $maxPrice !== null && $maxPrice !== '' && $minPrice > $maxPrice) {
            [$minPrice, $maxPrice] = [$maxPrice, $minPrice];
        }

        if ($minPrice !== null && $minPrice !== '') {
            $query->where('price', '>=', $minPrice);
        }

        if ($maxPrice !== null && $maxPrice !== '') {
            $query->where('price', '<=', $maxPrice);
        }

        // Ordenamos
        if ($request->has('sort') && $request->sort != '') {
            if ($request->sort === 'price_asc') {
                $query->orderBy('price', 'asc');
            } elseif ($request->sort === 'price_desc') {
                $query->orderBy('price', 'desc');
            } else {
                $query->orderBy('id', 'desc'); // Destacados o defecto
            }
        } else {
            $query->orderBy('id', 'desc');
        }
        
        // Paginamos los resultados
        $products = $query->paginate(12);

        if ($request->ajax()) {
            return view('catalog.partials.results', compact('products'))->render();
        }
        
        return view('catalog.index', compact('products', 'categories'));
    }

    /**
     * Muestra el detalle de un producto específico.
     */
    public function show($id)
    {
        $product = Product::with('categories')->where('status', 1)->findOrFail($id);
        
        $relatedProducts = Product::with('categories')
            ->where('status', 1)
            ->where('id', '!=', $id)
            ->inRandomOrder()
            ->take(4)
            ->get();
        
        return view('catalog.show', compact('product', 'relatedProducts'));
    }

    /**
     * Muestra la página principal (Home) con categorías resueltas y productos destacados.
     */
    public function home()
    {
        $categories = Category::all();
        
        $resolvedCategories = [];
        foreach ($categories as $category) {
            $nameLower = mb_strtolower($category->name);
            $bgUrl = 'https://images.unsplash.com/photo-1465146344425-f00d5f5c8f07?q=80&w=800&auto=format&fit=crop'; // default
            
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
            
            $resolvedCategories[] = [
                'id' => $category->id,
                'name' => $category->name,
                'description' => $category->description ?? 'Descubre nuestra selección de ' . $category->name,
                'bgUrl' => $bgUrl
            ];
        }

        $displayCategories = $resolvedCategories;
        if (count($resolvedCategories) > 0 && count($resolvedCategories) < 6) {
            $displayCategories = array_merge($resolvedCategories, $resolvedCategories);
            if (count($displayCategories) < 6) {
                $displayCategories = array_merge($displayCategories, $resolvedCategories);
            }
        }

        $featuredProducts = Product::with('categories')
            ->where('status', 1)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('home.index', compact('displayCategories', 'featuredProducts'));
    }
}
