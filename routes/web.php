<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

// Auth Routes from coworker
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

Route::get('/admin', function () {
    return "<h1>Panel de Administración (En preparación)</h1><p>Has entrado como admin.</p>";
});
