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
}
