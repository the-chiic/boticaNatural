@extends('landingPage')

@push('style')
    <link rel="stylesheet" href="{{ asset('css/styleCart.css') }}">
@endpush

@section('main_content')
    <div class="section-padding" style="background: var(--brand-cream); min-height: 80vh;">
        <div class="container">
            <h1 class="section-title mb-8">TU CARRITO</h1>

            <div class="cart-container-layout">
                <!-- Items -->
                <div class="cart-items-list">
                    @php
                        $items = [
                            ['name' => 'Infusión de Lavanda', 'price' => 12.50, 'qty' => 1, 'img' => 'https://images.unsplash.com/photo-1594631252845-29fc4586d51c?auto=format&fit=crop&q=80&w=200'],
                            ['name' => 'Aceite de Eucalipto', 'price' => 18.90, 'qty' => 2, 'img' => 'https://images.unsplash.com/photo-1611080626919-7cf5a9dbab5b?auto=format&fit=crop&q=80&w=200'],
                        ];
                    @endphp

                    @foreach($items as $item)
                    <div class="cart-item">
                        <img src="{{ $item['img'] }}" class="cart-item-img" alt="{{ $item['name'] }}">
                        <div class="cart-item-info">
                            <h4 style="font-weight: bold; margin-bottom: 0.5rem;">{{ $item['name'] }}</h4>
                            <span style="font-size: 0.875rem; color: rgba(27, 48, 34, 0.5);">Cantidad: {{ $item['qty'] }}</span>
                            <span style="font-size: 1rem; font-weight: bold; margin-top: 0.5rem;">{{ number_format($item['price'], 2) }}€</span>
                        </div>
                        <div style="display: flex; flex-direction: column; justify-content: space-between; align-items: flex-end;">
                            <button style="background: transparent; border: none; color: #ff4d4d; cursor: pointer; font-size: 0.75rem; text-transform: uppercase; font-weight: bold;">Eliminar</button>
                            <span style="font-weight: 300; font-size: 1.1rem;">{{ number_format($item['price'] * $item['qty'], 2) }}€</span>
                        </div>
                    </div>
                    @endforeach

                    @if(empty($items))
                        <div class="text-center py-12">
                            <p style="color: rgba(27, 48, 34, 0.5); margin-bottom: 2rem;">Tu carrito está vacío.</p>
                            <a href="/catalogo" class="btn-primary">Ir a la tienda</a>
                        </div>
                    @endif
                </div>

                <!-- Summary -->
                <aside class="cart-summary-panel">
                    <h3 style="font-size: 1.5rem; margin-bottom: 2.5rem;">RESUMEN</h3>
                    
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>50.30€</span>
                    </div>
                    <div class="summary-row">
                        <span>Envío</span>
                        <span style="color: #4ade80;">Gratis</span>
                    </div>
                    <div class="summary-row">
                        <span>Impuestos (IVA)</span>
                        <span>4.56€</span>
                    </div>

                    <div class="summary-row summary-total">
                        <span>TOTAL</span>
                        <span>50.30€</span>
                    </div>

                    <a href="/checkout" class="btn-primary" style="width: 100%; background: white; color: var(--brand-green); margin-top: 2rem; border-radius: 1rem;">
                        FINALIZAR COMPRA
                    </a>

                    <p style="font-size: 0.7rem; color: rgba(255, 255, 255, 0.5); text-align: center; margin-top: 1.5rem;">
                        Pago seguro garantizado. SSL Encriptado.
                    </p>
                </aside>
            </div>
        </div>
    </div>
@endsection
