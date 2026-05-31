<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ControladorPerfil extends Controller
{
    public function verPerfil()
    {
        $idUsuario = Auth::id();

        $pedidos = DB::table('orders')
            ->where('user_id', $idUsuario)
            ->orderBy('order_date', 'desc')
            ->get();

        $direcciones = DB::table('address')
            ->where('user_id', $idUsuario)
            ->get();

        return view('profile.index', compact('pedidos', 'direcciones'));
    }

    public function actualizarDatos(Request $solicitud)
    {
        $solicitud->validate([
            'name' => ['required', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:30'],
        ]);

        $usuario = Auth::user();

        $usuario->update([
            'name' => $solicitud->name,
            'phone' => $solicitud->phone,
        ]);

        return back()->with('success', '¡Tus datos personales se han actualizado con éxito!');
    }

    public function agregarDireccion(Request $solicitud)
    {
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

        return back()->with('success', '¡La nueva dirección ha sido añadida con éxito!');
    }

    public function eliminarDireccion($id)
    {
        $idUsuario = Auth::id();

        DB::table('address')
            ->where('id', $id)
            ->where('user_id', $idUsuario)
            ->delete();

        return back()->with('success', '¡La dirección ha sido eliminada con éxito!');
    }

    public function detallesPedido($id)
    {
        $idUsuario = Auth::id();

        $pedido = DB::table('orders')
            ->where('id', $id)
            ->where('user_id', $idUsuario)
            ->first();

        if (!$pedido) {
            return response()->json(['error' => 'Pedido no encontrado o no autorizado'], 403);
        }

        $lineas = DB::table('order_line')
            ->join('product', 'order_line.product_id', '=', 'product.id')
            ->where('order_line.order_id', $id)
            ->select('order_line.*', 'product.name as product_name')
            ->get();

        foreach ($lineas as $linea) {
            $product = \App\Models\Product::find($linea->product_id);
            $linea->product_image = $product ? $product->image_url : null;
        }

        return response()->json([
            'order' => $pedido,
            'lines' => $lineas
        ]);
    }
}
