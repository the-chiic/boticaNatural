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
        $direcciones = DB::table('address')
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

    // Añadir nueva dirección
    public function agregarDireccion(Request $solicitud)
    {
        // Validar campos recibidos
        $solicitud->validate([
            'address' => ['required', 'string', 'max:255'],
            'province' => ['nullable', 'string', 'max:100'],
            'city' => ['required', 'string', 'max:100'],
            'post_code' => ['required', 'string', 'max:20'],
            'country' => ['required', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:30'],
            'name_destination' => ['nullable', 'string', 'max:100'],
        ]);

        $idUsuario = Auth::id();

        // Insertar registro en la base de datos
        DB::table('address')->insert([
            'user_id' => $idUsuario,
            'address' => $solicitud->address,
            'province' => $solicitud->province,
            'city' => $solicitud->city,
            'post_code' => $solicitud->post_code,
            'country' => $solicitud->country,
            'phone' => $solicitud->phone,
            'name_destination' => $solicitud->name_destination ?? Auth::user()->name,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Volver atrás con alerta verde de éxito
        return back()->with('success', '¡La nueva dirección ha sido añadida con éxito!');
    }
}
