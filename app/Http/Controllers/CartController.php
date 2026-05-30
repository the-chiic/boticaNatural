<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderLine;
use App\Models\Payment;
use App\Models\Address;
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
        
        $discount = 0;
        if (session()->has('coupon')) {
            $promoDiscount = session()->get('coupon.discount');
            $discount = round($subtotal * ($promoDiscount / 100), 2);
        }

        $iva = round(($subtotal - $discount) * 0.21, 2); // 21% IVA incluido
        $total = max(0, $subtotal - $discount); // Envío gratis en nuestra botica

        return view('cart.index', compact('cart', 'subtotal', 'iva', 'total', 'discount'));
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
                'image' => $product->image_url
            ];
        }

        session()->put('cart', $cart);
        session()->save();

        return redirect()
            ->back()
            ->with('success', '¡Producto añadido al carrito!');
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

        if ($request->expectsJson()) {
            return response()->json($this->buildCartResponse($cart, (int) $id));
        }

        return redirect()->route('cart.index');
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

        // Asegurar valor por defecto para payment_method si viene vacío o nulo
        if (!$request->has('payment_method') || empty($request->input('payment_method'))) {
            $request->merge(['payment_method' => 'credit_card']);
        }

        $request->validate([
            'address_id' => 'nullable|integer|exists:address,id',
            'shipping_method' => 'required|string|in:standard,express,store_pickup',
            'payment_method' => 'required|string|in:credit_card,store_payment',
        ]);

        $shipping = $this->resolveShippingDetails($request);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return response()->json(['error' => 'El carrito está vacío.'], 400);
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['qty'];
        }

        // Apply discount from session coupon if any
        $discount = 0;
        if (session()->has('coupon')) {
            $promoDiscount = session()->get('coupon.discount');
            $discount = round($subtotal * ($promoDiscount / 100), 2);
        }

        $subtotalAfterDiscount = max(0, $subtotal - $discount);

        // Calcular costo de envío
        $shippingCost = 0.00;
        if ($request->shipping_method === 'standard') {
            $shippingCost = $subtotalAfterDiscount >= 50.00 ? 0.00 : 4.99;
        } elseif ($request->shipping_method === 'express') {
            $shippingCost = 9.99;
        } elseif ($request->shipping_method === 'store_pickup') {
            $shippingCost = 0.00;
        }

        $total = $subtotalAfterDiscount + $shippingCost;
        $userId = Auth::id();

        DB::beginTransaction();
        try {
            // 1. Crear el Pedido usando el modelo Order y create()
            $order = Order::create([
                'user_id' => $userId,
                'total_price' => $total,
                'order_date' => now(),
                'status' => 0, // 0 = Pendiente de pago
                'shipping_name' => $shipping['name_destination'],
                'shipping_address' => $shipping['address'],
                'shipping_city' => $shipping['city'],
                'shipping_post_code' => $shipping['post_code'],
                'shipping_country' => $shipping['country'],
                'shipping_phone' => $shipping['phone'],
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

            // Si es Pago en Tienda
            if ($request->payment_method === 'store_payment') {
                // Registrar Pago Pendiente en Tienda
                Payment::create([
                    'order_id' => $order->id,
                    'payment_details' => 'Pago en tienda (Efectivo/Tarjeta al recoger)',
                    'payment_status' => 0, // 0 = Pendiente
                    'reference' => 'STORE_PAYMENT_#BN-' . $order->id,
                    'amount' => $total,
                ]);

                // Descontar stock directamente de una vez
                foreach ($cart as $productId => $item) {
                    $product = Product::findOrFail($productId);
                    $product->decrement('stock', $item['qty']);
                }

                DB::commit();

                // Vaciar el carrito en la sesión
                session()->forget('cart');

                return response()->json([
                    'is_store_payment' => true,
                    'order_id' => $order->id,
                    'redirect' => route('cart.success', ['order_id' => $order->id])
                ]);
            }

            // 3. Crear el PaymentIntent en Stripe si es pago online
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
                'is_store_payment' => false,
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

    /**
     * Aplica un cupón de descuento al carrito de compras.
     */
    public function applyCoupon(Request $request)
    {
        $code = strtoupper($request->input('coupon_code'));
        if (empty($code)) {
            return redirect()->back()->withErrors(['coupon' => 'El código de cupón no puede estar vacío.']);
        }

        // Buscar promoción activa por su código
        $promo = \App\Models\Promotion::where('code', $code)
            ->where('is_active', true)
            ->where(function($q) {
                $q->whereNull('starts_at')->orWhere('starts_at', '<=', now());
            })
            ->where(function($q) {
                $q->whereNull('ends_at')->orWhere('ends_at', '>=', now());
            })
            ->first();

        if (!$promo) {
            return redirect()->back()->with('error', 'El código de cupón no es válido o ha expirado.');
        }

        session()->put('coupon', [
            'code' => $promo->code,
            'discount' => (float) $promo->discount
        ]);

        return redirect()->route('cart.index')->with('success', '¡Cupón de descuento aplicado con éxito!');
    }

    /**
     * Elimina el cupón de descuento activo en la sesión.
     */
    public function removeCoupon()
    {
        session()->forget('coupon');
        return redirect()->route('cart.index')->with('success', 'Cupón de descuento eliminado.');
    }

    /**
     * Obtiene los datos de envío desde una dirección guardada o del formulario manual.
     */
    private function resolveShippingDetails(Request $request): array
    {
        if ($request->filled('address_id')) {
            $address = Address::where('id', $request->address_id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            return [
                'name_destination' => $address->name_destination ?? Auth::user()->name,
                'address' => $address->address,
                'city' => $address->city,
                'post_code' => $address->post_code ?? '',
                'country' => $address->country,
                'phone' => $address->phone ?? Auth::user()->phone,
            ];
        }

        $request->validate([
            'name_destination' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'post_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'phone' => 'nullable|string|max:30',
        ]);

        return [
            'name_destination' => $request->name_destination,
            'address' => $request->address,
            'city' => $request->city,
            'post_code' => $request->post_code,
            'country' => $request->country,
            'phone' => $request->phone,
        ];
    }

    private function calculateCartTotals(array $cart): array
    {
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['qty'];
        }

        $discount = 0;
        if (session()->has('coupon')) {
            $discount = round($subtotal * (session('coupon.discount') / 100), 2);
        }

        $iva = round(($subtotal - $discount) * 0.21, 2);
        $total = max(0, $subtotal - $discount);

        return compact('subtotal', 'discount', 'iva', 'total');
    }

    private function buildCartResponse(array $cart, int $productId): array
    {
        $totals = $this->calculateCartTotals($cart);
        $cartCount = array_sum(array_column($cart, 'qty'));
        $item = $cart[$productId] ?? null;

        return [
            'success' => true,
            'product_id' => $productId,
            'removed' => $item === null,
            'qty' => $item['qty'] ?? 0,
            'line_total' => $item ? round($item['price'] * $item['qty'], 2) : 0,
            'cart_count' => $cartCount,
            'is_empty' => empty($cart),
            'formatted' => [
                'subtotal' => number_format($totals['subtotal'], 2),
                'discount' => number_format($totals['discount'], 2),
                'iva' => number_format($totals['iva'], 2),
                'total' => number_format($totals['total'], 2),
                'line_total' => $item ? number_format($item['price'] * $item['qty'], 2) : '0.00',
            ],
            ...$totals,
        ];
    }
}
