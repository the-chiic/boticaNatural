<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ControladorAutenticacion;
use App\Http\Controllers\ControladorPerfil;
use App\Http\Controllers\HomeController;

// ==========================================
// RUTAS PÚBLICAS (Accesibles por cualquiera)
// ==========================================

// Ruta principal (Index). Usa el método 'index' del HomeController.
Route::get('/', [HomeController::class, 'index'])->name('home');

// Catálogo de productos
Route::get('/catalogo', function () {
    return view('catalog.index');
});

Route::get('/producto/{id}', function () {
    return view('catalog.show');
});

// ==========================================
// RUTAS DE CARRITO Y PERFIL
// ==========================================

// El carrito está protegido manualmente (redirección en la vista), 
// aunque en un futuro debería usar el middleware 'auth'.
Route::get('/carrito', function () {
    if (!session('logged_in')) {
        return redirect('/login');
    }
    return view('cart.index');
});

Route::get('/checkout', function () {
    return view('cart.checkout');
});

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

    // Rutas para Recuperación de Contraseña (Forgot Password)
    Route::get('/recuperar-contrasena', [ControladorAutenticacion::class, 'mostrarFormularioRecuperar'])->name('password.request');
    Route::post('/recuperar-contrasena', [ControladorAutenticacion::class, 'enviarEnlaceRecuperacion'])->name('password.email');
    Route::get('/restablecer-contrasena/{token}', [ControladorAutenticacion::class, 'mostrarFormularioRestablecer'])->name('password.reset');
    Route::post('/restablecer-contrasena', [ControladorAutenticacion::class, 'actualizarContrasena'])->name('password.update');

    // Rutas para Verificación de Email (Account Verification)
    Route::get('/verificar-correo/aviso', [ControladorAutenticacion::class, 'mostrarAvisoVerificacion'])->name('verification.notice');
    Route::post('/verificar-correo/reenviar', [ControladorAutenticacion::class, 'reenviarVerificacion'])->name('verification.send');
    Route::get('/verificar-correo/{token}', [ControladorAutenticacion::class, 'verificarEmail'])->name('verification.verify');
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
    Route::get('/productos', [AdminController::class, 'productos'])->name('admin.productos');
    Route::get('/pedidos', [AdminController::class, 'pedidos'])->name('admin.pedidos');
    Route::get('/clientes', [AdminController::class, 'clientes'])->name('admin.clientes');
    Route::get('/estadisticas', [AdminController::class, 'estadisticas'])->name('admin.estadisticas');
    Route::get('/configuracion', [AdminController::class, 'configuracion'])->name('admin.configuracion');
});
