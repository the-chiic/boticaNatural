@extends('landingPage')

@push('style')
    <link rel="stylesheet" href="{{ asset('css/styleCart.css') }}">
@endpush

@section('main_content')
    <div class="section-padding" style="background: var(--brand-cream); min-height: 80vh; padding-top: 4rem;">
        <div class="container">
            <div class="flex justify-between items-center mb-8" style="border-bottom: 1px solid rgba(27, 48, 34, 0.08); padding-bottom: 1rem;">
                <h1 class="section-title" style="font-family: var(--fuente-serif); font-weight: 500; font-size: 2.2rem; margin-bottom: 0;">Tu Carrito</h1>
                @if(!empty($cart))
                <form action="{{ route('cart.clear') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-clear-cart" style="background: transparent; border: 1px solid rgba(27, 48, 34, 0.15); border-radius: 9999px; padding: 0.45rem 1.15rem; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: rgba(27, 48, 34, 0.6); cursor: pointer; transition: all 0.3s; font-family: var(--fuente-sans);">
                        <i class="fa-solid fa-rotate-left"></i> Vaciar Carrito
                    </button>
                </form>
                @endif
            </div>

            @if(empty($cart))
                <div class="no-products-container" style="text-align: center; padding: 6rem 2rem; background: rgba(255, 255, 255, 0.45); border-radius: 1.5rem; border: 1px dashed rgba(27, 48, 34, 0.12); box-shadow: var(--sombra-suave);">
                    <div style="font-size: 4rem; color: var(--brand-accent); opacity: 0.7; margin-bottom: 1.5rem;">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </div>
                    <h3 style="font-family: var(--fuente-serif); font-size: 1.6rem; font-weight: 500; color: var(--brand-green); margin-bottom: 0.75rem;">Tu carrito está vacío</h3>
                    <p style="font-size: 0.9rem; color: rgba(27, 48, 34, 0.6); max-width: 380px; margin: 0 auto 2.25rem; line-height: 1.6; font-family: var(--fuente-sans);">
                        Parece que aún no has seleccionado ningún tesoro de nuestra botica. Explora nuestro catálogo para encontrar el bienestar natural que necesitas.
                    </p>
                    <a href="{{ route('catalog.index') }}" class="btn-primary" style="display: inline-flex; width: auto; text-decoration: none; justify-content: center; font-family: var(--fuente-sans); border: 1px solid var(--brand-green); background: transparent; color: var(--brand-green);">
                        Ir a la tienda
                    </a>
                </div>
            @else
                <div class="cart-container-layout">
                    <!-- Items List -->
                    <div class="cart-items-list" style="box-shadow: var(--sombra-suave); border: 1px solid rgba(27, 48, 34, 0.05);">
                        @foreach($cart as $id => $item)
                        <div class="cart-item">
                            <img src="{{ $item['image'] ? asset('storage/' . $item['image']) : asset('img/imgPrueba.png') }}" class="cart-item-img" alt="{{ $item['name'] }}">
                            
                            <div class="cart-item-info">
                                <h4 style="font-family: var(--fuente-serif); font-size: 1.15rem; font-weight: 500; color: var(--brand-green); margin-bottom: 0.25rem;">{{ $item['name'] }}</h4>
                                <span style="font-size: 0.85rem; color: rgba(27, 48, 34, 0.5); font-family: var(--fuente-sans);">Precio unitario: {{ number_format($item['price'], 2) }}€</span>
                                
                                <!-- Quantity Controls via forms -->
                                <form action="{{ route('cart.update', $id) }}" method="POST" class="cart-update-form" style="margin-top: 0.75rem;">
                                    @csrf
                                    <div class="quantity-selector">
                                        <button type="submit" name="qty" value="{{ $item['qty'] - 1 }}" class="qty-btn">-</button>
                                        <input type="number" readonly value="{{ $item['qty'] }}" class="qty-input">
                                        <button type="submit" name="qty" value="{{ $item['qty'] + 1 }}" class="qty-btn">+</button>
                                    </div>
                                </form>
                            </div>

                            <div class="cart-item-actions">
                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-remove-item">
                                        <i class="fa-regular fa-trash-can"></i> Eliminar
                                    </button>
                                </form>
                                <span class="cart-item-total">{{ number_format($item['price'] * $item['qty'], 2) }}€</span>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Summary Panel -->
                    <aside class="cart-summary-panel">
                        <h3 class="summary-title">Resumen de Compra</h3>
                        
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span>{{ number_format($subtotal, 2) }}€</span>
                        </div>
                        <div class="summary-row">
                            <span>Envío</span>
                            <span class="text-free">Gratis</span>
                        </div>
                        <div class="summary-row summary-taxes">
                            <span>Impuestos (21% IVA inc.)</span>
                            <span>{{ number_format($iva, 2) }}€</span>
                        </div>

                        <div class="summary-row summary-total">
                            <span>TOTAL</span>
                            <span>{{ number_format($total, 2) }}€</span>
                        </div>

                        <a href="{{ route('cart.checkout') }}" class="btn-checkout">
                            Finalizar Compra
                        </a>

                        <p class="summary-secure-note">
                            <i class="fa-solid fa-lock"></i> Pago 100% seguro con encriptación SSL.
                        </p>
                    </aside>
                </div>
            @endif
        </div>
    </div>
@endsection
