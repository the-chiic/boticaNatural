<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ViewController extends Controller
{
    /**
     * Muestra la pantalla de checkout para finalizar el pedido.
     */
    public function checkout()
    {
        if (!session('logged_in') && !Auth::check()) {
            return redirect()->route('login');
        }

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('info', 'Añade productos antes de finalizar la compra.');
        }

        $user = Auth::user();
        
        // Obtener direcciones guardadas del usuario llamando al modelo Address
        $direcciones = Address::getByUserId($user->id);

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['qty'];
        }
        
        $discount = 0;
        if (session()->has('coupon')) {
            $promoDiscount = session()->get('coupon.discount');
            $discount = round($subtotal * ($promoDiscount / 100), 2);
        }

        $subtotalAfterDiscount = max(0, $subtotal - $discount);
        $total = $subtotalAfterDiscount; // El JS y backend agregarán el envío posteriormente

        // Obtener la clave pública de Stripe
        $stripeKey = config('services.stripe.key', env('STRIPE_KEY'));

        return view('cart.checkout', compact('cart', 'direcciones', 'user', 'subtotal', 'total', 'stripeKey', 'discount', 'subtotalAfterDiscount'));
    }

    /**
     * Muestra la vista de éxito tras una compra completada correctamente.
     */
    public function checkoutSuccess(Request $request)
    {
        if (!session('logged_in') && !Auth::check()) {
            return redirect()->route('login');
        }

        $orderId = $request->query('order_id');
        if (!$orderId) {
            return redirect()->route('home');
        }

        // Obtener el pedido y sus líneas de detalle llamando al modelo Order
        $order = Order::with(['lines.product'])->where('user_id', Auth::id())->findOrFail($orderId);

        return view('cart.success', compact('order'));
    }
}
