<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
     * Muestra la pantalla de checkout para finalizar el pedido.
     */
    public function checkout()
    {
        if (!session('logged_in')) {
            return redirect()->route('login');
        }

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('info', 'Añade productos antes de finalizar la compra.');
        }

        $user = Auth::user();
        
        // Obtener direcciones guardadas del usuario para el autocompletado
        $direcciones = DB::table('address')
            ->where('user_id', $user->id)
            ->get();

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['qty'];
        }
        $total = $subtotal;

        return view('cart.checkout', compact('cart', 'direcciones', 'user', 'subtotal', 'total'));
    }

    /**
     * Procesa la compra e inserta el pedido y sus líneas en base de datos.
     */
    public function placeOrder(Request $request)
    {
        if (!session('logged_in')) {
            return redirect()->route('login');
        }

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('info', 'El carrito está vacío.');
        }

        // Validación de datos
        $request->validate([
            'name_destination' => 'required|string|max:100',
            'post_code' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'phone' => 'nullable|string|max:30',
        ]);

        $userId = Auth::id();

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['qty'];
        }
        $total = $subtotal;

        DB::beginTransaction();
        try {
            // 1. Insertar el Pedido en 'orders'
            $orderId = DB::table('orders')->insertGetId([
                'user_id' => $userId,
                'total_price' => $total,
                'order_date' => now(),
                'status' => 0, // 0 = Pendiente (Por defecto según migración)
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 2. Insertar cada artículo en 'order_line'
            $numLine = 1;
            foreach ($cart as $productId => $item) {
                DB::table('order_line')->insert([
                    'order_id' => $orderId,
                    'num_line' => $numLine++,
                    'product_id' => $productId,
                    'unit' => $item['qty'],
                    'price' => $item['price'],
                    'total_price' => $item['price'] * $item['qty']
                ]);

                // 3. Reducir el stock del producto
                DB::table('product')
                    ->where('id', $productId)
                    ->decrement('stock', $item['qty']);
            }

            // 4. Registrar Pago Simulado en 'payments' si es necesario
            DB::table('payment')->insert([
                'order_id' => $orderId,
                'payment_details' => $request->input('payment_method') === 'paypal' ? 'PayPal Checkout' : 'Pago con Tarjeta Visa/Mastercard',
                'payment_status' => 'completed',
                'reference' => 'PAY-' . strtoupper(uniqid()),
                'amount' => $total,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            // Vaciar el carrito en la sesión
            session()->forget('cart');

            return redirect()->route('profile')->with('success_order', '¡Pedido #' . str_pad($orderId, 3, '0', STR_PAD_LEFT) . ' realizado con éxito!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Hubo un error al tramitar el pedido: ' . $e->getMessage()]);
        }
    }
}
