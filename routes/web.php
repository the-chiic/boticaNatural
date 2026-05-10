<?php

use Illuminate\Support\Facades\Route;

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

