<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderLine;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class CartController extends Controller
{
    /**
     * Muestra la vista del carrito con los productos reales en sesión.
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        
        // Calcular desgloses
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['qty'];
        }
        
        $iva = round($subtotal * 0.21, 2); // 21% IVA incluido
        $total = $subtotal; // Envío gratis en nuestra botica

        return view('cart.index', compact('cart', 'subtotal', 'iva', 'total'));
    }

    /**
     * Añade un producto al carrito (unidades variables).
     */
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $qty = (int) $request->input('qty', 1);
        if ($qty < 1) $qty = 1;

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['qty'] += $qty;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price' => (float) $product->price,
                'qty' => $qty,
                'image' => $product->image
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', '¡Producto añadido al carrito!');
    }

    /**
     * Actualiza la cantidad de un artículo.
     */
    public function update(Request $request, $id)
    {
        $qty = (int) $request->input('qty');
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            if ($qty > 0) {
                $cart[$id]['qty'] = $qty;
            } else {
                unset($cart[$id]);
            }
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', '¡Cantidad de producto actualizada!');
    }

    /**
     * Elimina un producto específico del carrito.
     */
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Producto eliminado de tu carrito.');
    }

    /**
     * Vacía el carrito completo de la sesión.
     */
    public function clear()
    {
        session()->forget('cart');

        return redirect()->route('cart.index')->with('success', 'El carrito ha sido vaciado correctamente.');
    }

    /**
     * Fase 1: Prepara el pedido, calcula importes y genera el PaymentIntent de Stripe.
     */
    public function preparePayment(Request $request)
    {
        if (!session('logged_in') && !Auth::check()) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        $request->validate([
            'name_destination' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'post_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'phone' => 'nullable|string|max:30',
            'shipping_method' => 'required|string|in:standard,express',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return response()->json(['error' => 'El carrito está vacío.'], 400);
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['qty'];
        }

        // Calcular costo de envío
        $shippingCost = 0.00;
        if ($request->shipping_method === 'standard') {
            $shippingCost = $subtotal >= 50.00 ? 0.00 : 4.99;
        } elseif ($request->shipping_method === 'express') {
            $shippingCost = 9.99;
        }

        $total = $subtotal + $shippingCost;
        $userId = Auth::id();

        DB::beginTransaction();
        try {
            // 1. Crear el Pedido usando el modelo Order y create()
            $order = Order::create([
                'user_id' => $userId,
                'total_price' => $total,
                'order_date' => now(),
                'status' => 0, // 0 = Pendiente de pago
                'shipping_name' => $request->name_destination,
                'shipping_address' => $request->address,
                'shipping_city' => $request->city,
                'shipping_post_code' => $request->post_code,
                'shipping_country' => $request->country,
                'shipping_phone' => $request->phone,
                'shipping_method' => $request->shipping_method,
                'shipping_cost' => $shippingCost,
            ]);

            // 2. Insertar cada artículo usando el modelo OrderLine y create()
            $numLine = 1;
            foreach ($cart as $productId => $item) {
                OrderLine::create([
                    'order_id' => $order->id,
                    'num_line' => $numLine++,
                    'product_id' => $productId,
                    'unit' => $item['qty'],
                    'price' => $item['price'],
                    'total_price' => $item['price'] * $item['qty']
                ]);
            }

            // 3. Crear el PaymentIntent en Stripe
            Stripe::setApiKey(config('services.stripe.secret', env('STRIPE_SECRET')));
            
            $paymentIntent = PaymentIntent::create([
                'amount' => (int) round($total * 100), // En céntimos
                'currency' => 'eur',
                'metadata' => [
                    'order_id' => $order->id,
                    'user_id' => $userId
                ]
            ]);

            // 4. Registrar Pago Pendiente usando el modelo Payment y create()
            Payment::create([
                'order_id' => $order->id,
                'payment_details' => 'Pago con tarjeta via Stripe',
                'payment_status' => 0, // 0 = Pendiente / No pagado
                'reference' => $paymentIntent->id,
                'amount' => $total,
            ]);

            DB::commit();

            return response()->json([
                'client_secret' => $paymentIntent->client_secret,
                'payment_intent_id' => $paymentIntent->id,
                'order_id' => $order->id,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Hubo un error al preparar el pago: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Fase 2: Confirma el estado del pago con Stripe, actualiza pedido/pago y reduce stock.
     */
    public function confirmPayment(Request $request)
    {
        if (!session('logged_in') && !Auth::check()) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        $request->validate([
            'order_id' => 'required|integer',
            'payment_intent_id' => 'required|string',
        ]);

        // 1. Obtener el pedido y verificar existencia
        $order = Order::where('user_id', Auth::id())->findOrFail($request->order_id);

        // Si ya está completado, retornar redirección de éxito
        if ($order->status == 1) {
            return response()->json([
                'success' => true,
                'redirect' => route('cart.success', ['order_id' => $order->id])
            ]);
        }

        // 2. Verificar el estado real en Stripe
        try {
            Stripe::setApiKey(config('services.stripe.secret', env('STRIPE_SECRET')));
            $intent = PaymentIntent::retrieve($request->payment_intent_id);

            if ($intent->status === 'succeeded') {
                DB::beginTransaction();

                // Actualizar el pedido a completado usando el modelo y update()
                $order->update([
                    'status' => 1,
                    'updated_at' => now()
                ]);

                // Actualizar el pago asociado a completado usando el modelo y update()
                $payment = Payment::where('order_id', $order->id)->first();
                if ($payment) {
                    $payment->update([
                        'payment_status' => 1,
                        'updated_at' => now()
                    ]);
                }

                // 3. Reducir stock real de los productos comprados
                $cart = session()->get('cart', []);
                foreach ($cart as $productId => $item) {
                    $product = Product::findOrFail($productId);
                    $product->decrement('stock', $item['qty']);
                }

                DB::commit();

                // Vaciar el carrito en la sesión
                session()->forget('cart');

                return response()->json([
                    'success' => true,
                    'redirect' => route('cart.success', ['order_id' => $order->id])
                ]);
            }

            return response()->json(['error' => 'El pago no se ha completado correctamente con Stripe.'], 400);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error de confirmación de pago: ' . $e->getMessage()], 500);
        }
    }
}
