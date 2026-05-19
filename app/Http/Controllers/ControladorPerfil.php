<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ControladorPerfil extends Controller
{
    // Mostrar la vista del Perfil con sus datos reales (Pedidos y Direcciones)
    public function verPerfil()
    {
        $idUsuario = Auth::id();

        // 1. Obtener los pedidos reales del usuario desde la base de datos MySQL
        $pedidos = DB::table('orders')
            ->where('user_id', $idUsuario)
            ->orderBy('order_date', 'desc')
            ->get();

        // 2. Obtener las direcciones reales del usuario desde la base de datos
        $direcciones = DB::table('addresses')
            ->where('user_id', $idUsuario)
            ->get();

        // Retornar la vista pasando los datos dinámicos
        return view('profile.index', compact('pedidos', 'direcciones'));
    }

    // Guardar cambios del perfil (Nombre y Teléfono)
    public function actualizarDatos(Request $solicitud)
    {
        // Validar campos recibidos
        $solicitud->validate([
            'name' => ['required', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:30'],
        ]);

        $usuario = Auth::user();

        // Actualizar el registro en la base de datos
        $usuario->update([
            'name' => $solicitud->name,
            'phone' => $solicitud->phone,
        ]);

        // Volver atrás con alerta verde de éxito
        return back()->with('success', '¡Tus datos personales se han actualizado con éxito!');
    }
}
