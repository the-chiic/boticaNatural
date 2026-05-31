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
                        <div class="cart-item" data-cart-item data-product-id="{{ $id }}">
                            <img src="{{ $item['image'] ? (str_starts_with($item['image'], 'http') ? $item['image'] : (str_starts_with($item['image'], 'img/') ? asset($item['image']) : asset('storage/' . $item['image']))) : asset('img/imgPrueba.png') }}" class="cart-item-img" alt="{{ $item['name'] }}">
                            
                            <div class="cart-item-info">
                                <h4 style="font-family: var(--fuente-serif); font-size: 1.15rem; font-weight: 500; color: var(--brand-green); margin-bottom: 0.25rem;">{{ $item['name'] }}</h4>
                                <span style="font-size: 0.85rem; color: rgba(27, 48, 34, 0.5); font-family: var(--fuente-sans);">Precio unitario: {{ number_format($item['price'], 2) }}€</span>
                                
                                <!-- Quantity Controls -->
                                <div class="quantity-selector" data-cart-qty-controls data-product-id="{{ $id }}" data-update-url="{{ route('cart.update', $id) }}" style="margin-top: 0.75rem;">
                                    <button type="button" class="qty-btn" data-qty-action="decrease" aria-label="Reducir cantidad">-</button>
                                    <input type="number" readonly value="{{ $item['qty'] }}" class="qty-input" data-cart-qty>
                                    <button type="button" class="qty-btn" data-qty-action="increase" aria-label="Aumentar cantidad">+</button>
                                </div>
                            </div>

                            <div class="cart-item-actions">
                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-remove-item">
                                        <i class="fa-regular fa-trash-can"></i> Eliminar
                                    </button>
                                </form>
                                <span class="cart-item-total" data-cart-line-total>{{ number_format($item['price'] * $item['qty'], 2) }}€</span>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Summary Panel -->
                    <aside class="cart-summary-panel">
                        <h3 class="summary-title">Resumen de Compra</h3>
                        
                        @if(session('error'))
                            <div style="background: rgba(239, 68, 68, 0.1); color: #dc2626; padding: 0.65rem 1rem; border-radius: 0.5rem; font-size: 0.8rem; margin-bottom: 1rem; font-family: var(--fuente-sans); border: 1px solid rgba(239,68,68,0.2);">
                                <i class="fa-solid fa-circle-xmark"></i> {{ session('error') }}
                            </div>
                        @endif

                        @if(session('success'))
                            <div style="background: rgba(16, 185, 129, 0.1); color: #059669; padding: 0.65rem 1rem; border-radius: 0.5rem; font-size: 0.8rem; margin-bottom: 1rem; font-family: var(--fuente-sans); border: 1px solid rgba(16,185,129,0.2);">
                                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                            </div>
                        @endif

                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span data-cart-subtotal>{{ number_format($subtotal, 2) }}€</span>
                        </div>

                        @if(isset($discount) && $discount > 0)
                        <div class="summary-row" data-cart-discount-row style="color: #a7f3d0; font-weight: 700; background: rgba(166, 243, 208, 0.08); padding: 0.65rem 0.85rem; border-radius: 0.75rem; border: 1px dashed rgba(166, 243, 208, 0.25); margin-bottom: 1.25rem;">
                            <span style="display: flex; align-items: center; gap: 0.4rem;"><i class="fa-solid fa-gift" style="color: #8B6F4A; font-size: 1rem;"></i> Descuento (Cupón)</span>
                            <span data-cart-discount>-{{ number_format($discount, 2) }}€</span>
                        </div>
                        @endif

                        <div class="summary-row">
                            <span>Envío</span>
                            <span class="text-free">Gratis</span>
                        </div>
                        <div class="summary-row summary-taxes">
                            <span>Impuestos (21% IVA inc.)</span>
                            <span data-cart-iva>{{ number_format($iva, 2) }}€</span>
                        </div>

                        <div class="summary-row summary-total">
                            <span>TOTAL</span>
                            <span data-cart-total>{{ number_format($total, 2) }}€</span>
                        </div>

                        <!-- Coupon application form -->
                        <div class="coupon-section" style="margin-top: 1.5rem; border-top: 1px solid rgba(250, 249, 246, 0.12); padding-top: 1.25rem; margin-bottom: 1.5rem;">
                            @if(session()->has('coupon'))
                                <div class="coupon-active-badge">
                                    <span class="coupon-active-details">
                                        <i class="fa-solid fa-tag coupon-icon-tag"></i> 
                                        Cupón: <strong class="coupon-code-text">{{ session('coupon.code') }}</strong> 
                                        <span class="coupon-discount-text">(-{{ session('coupon.discount') }}%)</span>
                                    </span>
                                    <form action="{{ route('cart.coupon.remove') }}" method="POST" style="margin: 0; padding: 0; display: inline;">
                                        @csrf
                                        <button type="submit" title="Eliminar cupón" class="coupon-remove-btn">
                                            <i class="fa-solid fa-circle-xmark"></i>
                                        </button>
                                    </form>
                                </div>
                            @else
                                <form action="{{ route('cart.coupon.apply') }}" method="POST" class="coupon-apply-form" style="display: flex; gap: 0.5rem; width: 100%;">
                                    @csrf
                                    <input type="text" name="coupon_code" placeholder="Código de cupón" required style="flex: 1; min-width: 0; padding: 0.65rem 1rem; border-radius: 9999px; border: 1px solid rgba(250,249,246,0.15); font-size: 0.85rem; font-family: var(--fuente-sans); outline: none; background: rgba(250,249,246,0.06); color: #ffffff;">
                                    <button type="submit" class="btn-primary" style="padding: 0.65rem 1.25rem; font-size: 0.8rem; border-radius: 9999px; width: auto; font-family: var(--fuente-sans); background: #FAF9F6; color: var(--brand-green); border: none; cursor: pointer; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; transition: all 0.3s;" onmouseover="this.style.background='var(--brand-accent)'; this.style.color='#ffffff';" onmouseout="this.style.background='#FAF9F6'; this.style.color='var(--brand-green)';">
                                        Aplicar
                                    </button>
                                </form>
                            @endif
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

@push('scripts')
<script src="{{ asset('js/jsCart.js') }}"></script>
@endpush
