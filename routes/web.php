<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('home.index');
});

Route::get('/catalogo', function () {
    return view('catalog.index');
});

Route::get('/producto/{id}', function () {
    return view('catalog.show');
});

Route::get('/carrito', function () {
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
    if ($request->email === 'admin' && $request->password === '12345') {
        return redirect('/admin');
    }
    // Para el demo, cualquier otro login va al perfil
    return redirect('/perfil');
});

Route::get('/register', function () {
    return view('auth.register');
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
