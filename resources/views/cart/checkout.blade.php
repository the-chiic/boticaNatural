@extends('landingPage')

@push('style')
    <link rel="stylesheet" href="{{ asset('css/styleCheckout.css') }}">
@endpush

@section('main_content')
    <div class="section-padding" style="background: var(--brand-cream); min-height: 100vh; padding-top: 4rem;">
        <div class="container">
            <h1 class="section-title mb-8" style="font-family: var(--fuente-serif); font-weight: 500; font-size: 2.2rem;">Finalizar Pedido</h1>

            @if($errors->any())
                <div style="background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 1rem; border-radius: 0.75rem; margin-bottom: 2rem; font-family: var(--fuente-sans); font-size: 0.9rem;">
                    <ul style="margin: 0; padding-left: 1.25rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="checkoutForm" action="{{ route('cart.placeOrder') }}" method="POST">
                @csrf
                <div class="checkout-layout">
                    <!-- Shipping & Payment Form Section -->
                    <div class="checkout-form-section">
                        
                        <!-- Shipping Info -->
                        <section style="margin-bottom: 3.5rem;">
                            <h2 class="checkout-title">1. Información de Envío</h2>
                            
                            <div class="form-group-grid">
                                
                                <!-- Address Dropdown (If customer has saved ones) -->
                                @if($direcciones->isNotEmpty())
                                <div style="grid-column: span 2; margin-bottom: 0.5rem;">
                                    <label>¿USAR UNA DIRECCIÓN GUARDADA?</label>
                                    <select id="saved_address" class="input-field" onchange="fillAddress(this)">
                                        <option value="">-- Seleccionar una dirección guardada --</option>
                                        @foreach($direcciones as $dir)
                                            <option value="{{ $dir->id }}" 
                                                    data-name="{{ $dir->name_destination }}" 
                                                    data-address="{{ $dir->address }}" 
                                                    data-city="{{ $dir->city }}" 
                                                    data-postcode="{{ $dir->post_code }}"
                                                    data-country="{{ $dir->country }}"
                                                    data-phone="{{ $dir->phone }}">
                                                {{ $dir->name_destination }} - {{ $dir->address }}, {{ $dir->city }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
 
                                <div style="grid-column: span 2;">
                                    <label>RECEPTOR (NOMBRE Y APELLIDOS)</label>
                                    <input type="text" id="name_destination" name="name_destination" class="input-field" placeholder="Nombre completo de quien recibe" value="{{ old('name_destination', $user->name) }}" required style="width: 100%;">
                                </div>
                                
                                <div style="grid-column: span 2;">
                                    <label>DIRECCIÓN DE ENTREGA</label>
                                    <input type="text" id="address" name="address" class="input-field" placeholder="Calle, número, piso, puerta..." value="{{ old('address') }}" required style="width: 100%;">
                                </div>
                                
                                <div style="grid-column: span 1;">
                                    <label>CIUDAD</label>
                                    <input type="text" id="city" name="city" class="input-field" placeholder="Ej. Madrid" value="{{ old('city') }}" required style="width: 100%;">
                                </div>
                                
                                <div style="grid-column: span 1;">
                                    <label>CÓDIGO POSTAL</label>
                                    <input type="text" id="post_code" name="post_code" class="input-field" placeholder="Ej. 28001" value="{{ old('post_code') }}" required style="width: 100%;">
                                </div>
 
                                <div style="grid-column: span 1;">
                                    <label>PAÍS</label>
                                    <input type="text" id="country" name="country" class="input-field" placeholder="Ej. España" value="{{ old('country', 'España') }}" required style="width: 100%;">
                                </div>
 
                                <div style="grid-column: span 1;">
                                    <label>TELÉFONO DE CONTACTO</label>
                                    <input type="text" id="phone" name="phone" class="input-field" placeholder="Ej. +34 600123456" value="{{ old('phone', $user->phone) }}" style="width: 100%;">
                                </div>
 
                             </div>
                        </section>
 
                        <!-- Payment Method Info -->
                        <section>
                            <h2 class="checkout-title">2. Método de Pago</h2>
                            
                            <div class="payment-methods-list">
                                <label class="payment-method-card selected">
                                    <input type="radio" name="payment_method" value="credit_card" checked onchange="togglePaymentCards(this)">
                                    <div class="flex items-center gap-3" style="display: flex; align-items: center; gap: 0.75rem;">
                                        <i class="fas fa-credit-card" style="color: var(--brand-green); font-size: 1.15rem;"></i>
                                        <span style="font-size: 0.9rem; font-weight: 600; color: var(--brand-green);">Tarjeta de Crédito o Débito</span>
                                    </div>
                                </label>
                                <label class="payment-method-card">
                                    <input type="radio" name="payment_method" value="paypal" onchange="togglePaymentCards(this)">
                                    <div class="flex items-center gap-3" style="display: flex; align-items: center; gap: 0.75rem;">
                                        <i class="fab fa-paypal" style="color: #003087; font-size: 1.15rem;"></i>
                                        <span style="font-size: 0.9rem; font-weight: 600; color: var(--brand-green);">PayPal</span>
                                    </div>
                                </label>
                            </div>
                        </section>
                    </div>
 
                    <!-- Order Review Sidebar Card -->
                    <aside class="order-review-card">
                        <h3>Tu Pedido</h3>
                        
                        <div class="order-review-item-container">
                            @foreach($cart as $item)
                            <div class="order-review-item">
                                <span style="max-width: 70%;">{{ $item['name'] }} <strong style="color: var(--brand-accent);">x{{ $item['qty'] }}</strong></span>
                                <span style="font-weight: 500;">{{ number_format($item['price'] * $item['qty'], 2) }}€</span>
                            </div>
                            @endforeach
                        </div>
 
                        <div class="order-review-totals">
                            <div class="order-review-row">
                                <span>Subtotal</span>
                                <span>{{ number_format($subtotal, 2) }}€</span>
                            </div>
                            <div class="order-review-row">
                                <span>Gastos de Envío</span>
                                <span style="color: var(--brand-accent); font-weight: bold;">Gratis</span>
                            </div>
                            <div class="order-review-row total-row">
                                <span>TOTAL</span>
                                <span>{{ number_format($total, 2) }}€</span>
                            </div>
                        </div>
 
                        <button type="submit" class="btn-submit-checkout">
                            Confirmar y Pagar
                        </button>
                    </aside>
                </div>
            </form>
        </div>
    </div>
@endsection
 
@push('scripts')
<script>
    function fillAddress(select) {
        const option = select.options[select.selectedIndex];
        if (!option || !option.value) return;
 
        document.getElementById('name_destination').value = option.getAttribute('data-name') || '';
        document.getElementById('address').value = option.getAttribute('data-address') || '';
        document.getElementById('city').value = option.getAttribute('data-city') || '';
        document.getElementById('post_code').value = option.getAttribute('data-postcode') || '';
        document.getElementById('country').value = option.getAttribute('data-country') || '';
        document.getElementById('phone').value = option.getAttribute('data-phone') || '';
    }

    function togglePaymentCards(radio) {
        document.querySelectorAll('.payment-method-card').forEach(card => {
            card.classList.remove('selected');
        });
        if (radio.checked) {
            radio.closest('.payment-method-card').classList.add('selected');
        }
    }
</script>
@endpush
