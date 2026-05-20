<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Models\Category;

Route::get('/', function () {
    $categories = Category::all();
    return view('home.index', compact('categories'));
});

Route::get('/catalogo', [App\Http\Controllers\CatalogController::class, 'index'])->name('catalog.index');

Route::get('/producto/{id}', [App\Http\Controllers\CatalogController::class, 'show'])->name('catalog.show');

Route::get('/carrito', function () {
    if (!session('logged_in')) {
        return redirect('/login');
    }
    return view('cart.index');
});

Route::get('/checkout', function () {
    return view('cart.checkout');
});

Route::get('/perfil', function () {
    return view('profile.index');
});

// Auth Routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    session(['logged_in' => true]);
    if ($request->email === 'admin' && $request->password === '12345') {
        return redirect('/admin');
    }
    // Para el demo, cualquier otro login va al perfil
    return redirect('/perfil');
});

Route::get('/register', function () {
    return view('auth.register');
});

Route::get('/logout', function () {
    session()->forget('logged_in');
    return redirect('/');
});

// Admin Routes (Organized)
Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/productos', [AdminController::class, 'productos'])->name('admin.productos');
    Route::get('/pedidos', [AdminController::class, 'pedidos'])->name('admin.pedidos');
    Route::get('/clientes', [AdminController::class, 'clientes'])->name('admin.clientes');
    Route::get('/estadisticas', [AdminController::class, 'estadisticas'])->name('admin.estadisticas');
    Route::get('/configuracion', [AdminController::class, 'configuracion'])->name('admin.configuracion');
});
