<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewController;

Route::get('/', [ViewController::class, 'dashboard'])->name('dashboard');
Route::get('/productos', [ViewController::class, 'productos'])->name('productos.index');
Route::get('/pedidos', [ViewController::class, 'pedidos'])->name('pedidos.index');
Route::get('/clientes', [ViewController::class, 'clientes'])->name('clientes.index');
Route::get('/estadisticas', [ViewController::class, 'estadisticas'])->name('estadisticas');
Route::get('/configuracion', [ViewController::class, 'configuracion'])->name('configuracion');
