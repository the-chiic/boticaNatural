<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ControladorAutenticacion;
use App\Http\Controllers\ControladorPerfil;
use App\Http\Controllers\CartController;
use App\Models\Category;
use App\Models\Product;

Route::get('/', [App\Http\Controllers\CatalogController::class, 'home'])->name('home');

Route::get('/catalogo', [App\Http\Controllers\CatalogController::class, 'index'])->name('catalog.index');

Route::get('/producto/{id}', [App\Http\Controllers\CatalogController::class, 'show'])->name('catalog.show');

// ==========================================
// RUTAS DE CARRITO Y PERFIL
// ==========================================

Route::get('/carrito', [CartController::class, 'index'])->name('cart.index');
Route::post('/carrito/anadir/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/carrito/actualizar/{id}', [CartController::class, 'update'])->name('cart.update');
Route::post('/carrito/eliminar/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/carrito/vaciar', [CartController::class, 'clear'])->name('cart.clear');

Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/checkout', [CartController::class, 'placeOrder'])->name('cart.placeOrder');


// Auth Routes
Route::middleware('guest')->group(function () {
    // Rutas de Login normal en Español
    Route::get('/iniciar-sesion', [ControladorAutenticacion::class, 'mostrarFormularioLogin'])->name('login');
    Route::post('/iniciar-sesion', [ControladorAutenticacion::class, 'iniciarSesion']);
    
    // Rutas de Registro normal en Español
    Route::get('/registrarse', [ControladorAutenticacion::class, 'mostrarFormularioRegistro'])->name('register');
    Route::post('/registrarse', [ControladorAutenticacion::class, 'registrar']);
    
    // Rutas para Login con Google en Español
    Route::get('/autenticacion/google', [ControladorAutenticacion::class, 'redireccionarAGoogle'])->name('login.google');
    Route::get('/autenticacion/google/callback', [ControladorAutenticacion::class, 'manejarCallbackGoogle']);
});

Route::middleware('auth')->group(function () {
    // Rutas protegidas (sólo usuarios logueados pueden salir)
    Route::post('/cerrar-sesion', [ControladorAutenticacion::class, 'cerrarSesion'])->name('logout');
    // Para mantener compatibilidad si usan enlaces <a>
    Route::get('/cerrar-sesion', [ControladorAutenticacion::class, 'cerrarSesion']);
    
    // Perfil de usuario protegido y dinámico
    Route::get('/perfil', [ControladorPerfil::class, 'verPerfil'])->name('profile');
    Route::put('/perfil/actualizar', [ControladorPerfil::class, 'actualizarDatos'])->name('profile.update');
    Route::post('/perfil/direccion', [ControladorPerfil::class, 'agregarDireccion'])->name('profile.address.add');
});

// Admin Routes (Organized)
Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Productos CRUD
    Route::get('/productos', [AdminController::class, 'productos'])->name('admin.productos');
    Route::post('/productos', [AdminController::class, 'guardarProducto'])->name('admin.productos.store');
    Route::post('/productos/{id}', [AdminController::class, 'actualizarProducto'])->name('admin.productos.update');
    Route::post('/productos/{id}/eliminar', [AdminController::class, 'eliminarProducto'])->name('admin.productos.delete');
    
    // Pedidos Management
    Route::get('/pedidos', [AdminController::class, 'pedidos'])->name('admin.pedidos');
    Route::get('/pedidos/exportar', [AdminController::class, 'exportarPedidos'])->name('admin.pedidos.export');
    Route::post('/pedidos/{id}/estado', [AdminController::class, 'actualizarEstadoPedido'])->name('admin.pedidos.status');
    Route::get('/pedidos/{id}/detalles', [AdminController::class, 'detallesPedido'])->name('admin.pedidos.details');
    
    Route::get('/clientes', [AdminController::class, 'clientes'])->name('admin.clientes');
    Route::get('/clientes/{id}/detalles', [AdminController::class, 'detallesCliente'])->name('admin.clientes.details');
    Route::get('/estadisticas', [AdminController::class, 'estadisticas'])->name('admin.estadisticas');
    
    // Categorías CRUD
    Route::get('/categorias', [AdminController::class, 'categorias'])->name('admin.categorias');
    Route::post('/categorias', [AdminController::class, 'guardarCategoria'])->name('admin.categorias.store');
    Route::post('/categorias/{id}', [AdminController::class, 'actualizarCategoria'])->name('admin.categorias.update');
    Route::post('/categorias/{id}/eliminar', [AdminController::class, 'eliminarCategoria'])->name('admin.categorias.delete');

    // Promociones CRUD
    Route::get('/promociones', [AdminController::class, 'promociones'])->name('admin.promociones');
    Route::post('/promociones', [AdminController::class, 'guardarPromocion'])->name('admin.promociones.store');
    Route::post('/promociones/{id}', [AdminController::class, 'actualizarPromocion'])->name('admin.promociones.update');
    Route::post('/promociones/{id}/eliminar', [AdminController::class, 'eliminarPromocion'])->name('admin.promociones.delete');

    // Configuración general y seguridad
    Route::get('/configuracion', [AdminController::class, 'configuracion'])->name('admin.configuracion');
    Route::post('/configuracion', [AdminController::class, 'guardarConfiguracion'])->name('admin.configuracion.save');
    Route::post('/configuracion/seguridad', [AdminController::class, 'guardarSeguridad'])->name('admin.configuracion.security');
});

// Ruta de mantenimiento pública
Route::get('/mantenimiento', function () {
    if (!\Illuminate\Support\Facades\Cache::get('maintenance_mode', false)) {
        return redirect('/');
    }
    return view('errors.maintenance');
})->name('maintenance');

