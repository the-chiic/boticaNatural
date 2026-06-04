<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Sincronizar sesión logged_in con Auth
        if (Auth::check() && !session('logged_in')) {
            session(['logged_in' => true]);
        }

        // Verificar si el Modo Mantenimiento está activo en la caché
        if (Cache::get('maintenance_mode', false)) {
            // Excluir rutas de administración, inicio de sesión y la propia página de mantenimiento
            if (!$request->is('admin') && 
                !$request->is('admin/*') && 
                !$request->is('iniciar-sesion') && 
                !$request->is('cerrar-sesion') &&
                !$request->is('mantenimiento')) {
                
                return redirect()->route('maintenance');
            }
        }

        return $next($request);
    }
}
