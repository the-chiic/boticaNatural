<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ViewController extends Controller
{
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
        $direcciones = Address::where('user_id', Auth::id())->orderByDesc('created_at')->get();

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
        $total = $subtotalAfterDiscount;

        $stripeKey = config('services.stripe.key', env('STRIPE_KEY'));

        return view('cart.checkout', compact('cart', 'direcciones', 'user', 'subtotal', 'total', 'stripeKey', 'discount', 'subtotalAfterDiscount'));
    }

    public function checkoutSuccess(Request $request)
    {
        if (!session('logged_in') && !Auth::check()) {
            return redirect()->route('login');
        }

        $orderId = $request->query('order_id');
        if (!$orderId) {
            return redirect()->route('home');
        }

        $order = Order::with(['lines.product'])->where('user_id', Auth::id())->findOrFail($orderId);

        return view('cart.success', compact('order'));
    }
}
