<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminAuthController;

Route::get('/login', [AdminAuthController::class, 'mostrarFormularioLogin'])->name('admin.login');
Route::post('/login', [AdminAuthController::class, 'iniciarSesion']);
Route::post('/logout', [AdminAuthController::class, 'cerrarSesion'])->name('admin.logout');

Route::middleware(['auth.admin'])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/productos', [AdminController::class, 'productos'])->name('admin.productos');
    Route::post('/productos', [AdminController::class, 'guardarProducto'])->name('admin.productos.store');
    Route::put('/productos/{id}', [AdminController::class, 'actualizarProducto'])->name('admin.productos.update');
    Route::post('/productos/{id}/eliminar', [AdminController::class, 'eliminarProducto'])->name('admin.productos.delete');
    Route::get('/pedidos', [AdminController::class, 'pedidos'])->name('admin.pedidos');
    Route::get('/pedidos/exportar', [AdminController::class, 'exportarPedidos'])->name('admin.pedidos.export');
    Route::post('/pedidos/{id}/estado', [AdminController::class, 'actualizarEstadoPedido'])->name('admin.pedidos.status');
    Route::get('/pedidos/{id}/detalles', [AdminController::class, 'detallesPedido'])->name('admin.pedidos.details');
    Route::get('/clientes', [AdminController::class, 'clientes'])->name('admin.clientes');
    Route::get('/clientes/{id}/detalles', [AdminController::class, 'detallesCliente'])->name('admin.clientes.details');
    Route::get('/estadisticas', [AdminController::class, 'estadisticas'])->name('admin.estadisticas');
    Route::get('/categorias', [AdminController::class, 'categorias'])->name('admin.categorias');
    Route::post('/categorias', [AdminController::class, 'guardarCategoria'])->name('admin.categorias.store');
    Route::post('/categorias/{id}', [AdminController::class, 'actualizarCategoria'])->name('admin.categorias.update');
    Route::post('/categorias/{id}/eliminar', [AdminController::class, 'eliminarCategoria'])->name('admin.categorias.delete');
    Route::get('/promociones', [AdminController::class, 'promociones'])->name('admin.promociones');
    Route::post('/promociones', [AdminController::class, 'guardarPromocion'])->name('admin.promociones.store');
    Route::post('/promociones/{id}', [AdminController::class, 'actualizarPromocion'])->name('admin.promociones.update');
    Route::post('/promociones/{id}/eliminar', [AdminController::class, 'eliminarPromocion'])->name('admin.promociones.delete');
    Route::put('/promociones/{id}/toggle', [AdminController::class, 'togglePromocion'])->name('admin.promociones.toggle');
    Route::put('/promociones/{id}/toggle-web', [AdminController::class, 'togglePromocionWeb'])->name('admin.promociones.toggleWeb');
    Route::get('/configuracion', [AdminController::class, 'configuracion'])->name('admin.configuracion');
    Route::post('/configuracion/info-tienda', [AdminController::class, 'guardarInfoTienda'])->name('admin.configuracion.save.info');
    Route::post('/configuracion/preferencias', [AdminController::class, 'guardarPreferencias'])->name('admin.configuracion.save.preferences');
    Route::post('/configuracion/seguridad', [AdminController::class, 'guardarSeguridad'])->name('admin.configuracion.security');
    Route::get('/notas', [AdminController::class, 'obtenerNotas'])->name('admin.notas.get');
    Route::post('/notas', [AdminController::class, 'guardarNotas'])->name('admin.notas.save');
});
