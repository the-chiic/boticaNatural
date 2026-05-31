<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\ControladorAutenticacion;
use App\Http\Controllers\ControladorPerfil;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ViewController;
use App\Models\Category;
use App\Models\Product;

Route::get('/', [App\Http\Controllers\CatalogController::class, 'home'])->name('home');

Route::get('/catalogo', [App\Http\Controllers\CatalogController::class, 'index'])->name('catalog.index');

Route::get('/producto/{id}', [App\Http\Controllers\CatalogController::class, 'show'])->name('catalog.show');

Route::get('/aviso-legal', fn() => view('legal.aviso'))->name('legal.aviso');
Route::get('/privacidad', fn() => view('legal.privacidad'))->name('legal.privacidad');
Route::get('/cookies', fn() => view('legal.cookies'))->name('legal.cookies');

Route::get('/carrito', [CartController::class, 'index'])->name('cart.index');
Route::post('/carrito/anadir/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/carrito/actualizar/{id}', [CartController::class, 'update'])->name('cart.update');
Route::post('/carrito/eliminar/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/carrito/vaciar', [CartController::class, 'clear'])->name('cart.clear');
Route::post('/carrito/cupon/aplicar', [CartController::class, 'applyCoupon'])->name('cart.coupon.apply');
Route::post('/carrito/cupon/eliminar', [CartController::class, 'removeCoupon'])->name('cart.coupon.remove');

Route::get('/checkout', [ViewController::class, 'checkout'])->name('cart.checkout');
Route::post('/checkout/prepare', [CartController::class, 'preparePayment'])->name('cart.preparePayment');
Route::post('/checkout/confirm', [CartController::class, 'confirmPayment'])->name('cart.confirmPayment');
Route::get('/checkout/success', [ViewController::class, 'checkoutSuccess'])->name('cart.success');

Route::middleware('guest')->group(function () {
    Route::get('/iniciar-sesion', [ControladorAutenticacion::class, 'mostrarFormularioLogin'])->name('login');
    Route::post('/iniciar-sesion', [ControladorAutenticacion::class, 'iniciarSesion']);
    Route::get('/registrarse', [ControladorAutenticacion::class, 'mostrarFormularioRegistro'])->name('register');
    Route::post('/registrarse', [ControladorAutenticacion::class, 'registrar']);
    Route::get('/autenticacion/google', [ControladorAutenticacion::class, 'redireccionarAGoogle'])->name('login.google');
    Route::get('/autenticacion/google/callback', [ControladorAutenticacion::class, 'manejarCallbackGoogle']);
    Route::get('/recuperar-contrasena', [ControladorAutenticacion::class, 'mostrarFormularioRecuperar'])->name('password.request');
    Route::post('/recuperar-contrasena', [ControladorAutenticacion::class, 'enviarEnlaceRecuperacion'])->name('password.email');
    Route::get('/restablecer-contrasena/{token}', [ControladorAutenticacion::class, 'mostrarFormularioRestablecer'])->name('password.reset');
    Route::post('/restablecer-contrasena', [ControladorAutenticacion::class, 'actualizarContrasena'])->name('password.update');
    Route::get('/verificar-correo/aviso', [ControladorAutenticacion::class, 'mostrarAvisoVerificacion'])->name('verification.notice');
    Route::post('/verificar-correo/reenviar', [ControladorAutenticacion::class, 'reenviarVerificacion'])->name('verification.send');
    Route::get('/verificar-correo/{token}', [ControladorAutenticacion::class, 'verificarEmail'])->name('verification.verify');
});

Route::middleware('auth')->group(function () {
    Route::post('/cerrar-sesion', [ControladorAutenticacion::class, 'cerrarSesion'])->name('logout');
    Route::get('/cerrar-sesion', [ControladorAutenticacion::class, 'cerrarSesion']);
    Route::get('/perfil', [ControladorPerfil::class, 'verPerfil'])->name('profile');
    Route::put('/perfil/actualizar', [ControladorPerfil::class, 'actualizarDatos'])->name('profile.update');
    Route::post('/perfil/direccion', [ControladorPerfil::class, 'agregarDireccion'])->name('profile.address.add');
    Route::delete('/perfil/direccion/{id}', [ControladorPerfil::class, 'eliminarDireccion'])->name('profile.address.delete');
    Route::get('/perfil/pedido/{id}/detalles', [ControladorPerfil::class, 'detallesPedido'])->name('profile.order.details');
});

Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'mostrarFormularioLogin'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'iniciarSesion']);
    Route::post('/logout', [AdminAuthController::class, 'cerrarSesion'])->name('admin.logout');
});

Route::prefix('admin')->middleware(['auth.admin'])->group(function () {
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

Route::get('/mantenimiento', function () {
    if (!\Illuminate\Support\Facades\Cache::get('maintenance_mode', false)) {
        return redirect('/');
    }
    return view('errors.maintenance');
})->name('maintenance');

Route::get('/run-migrations', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        return 'Migraciones ejecutadas correctamente:<br><pre>' . \Illuminate\Support\Facades\Artisan::output() . '</pre>';
    } catch (\Exception $e) {
        return 'Error al ejecutar las migraciones: ' . $e->getMessage();
    }
});




