@extends('landingPage')

@push('style')
    <link rel="stylesheet" href="{{ asset('css/styleCheckout.css') }}">
@endpush

@section('main_content')
    <div class="section-padding" style="background: var(--brand-cream); min-height: 100vh; padding-top: 4.5rem; padding-bottom: 5rem;">
        <div class="container">
            <h1 style="font-family: var(--fuente-serif); font-weight: 500; font-size: 2.5rem; color: var(--brand-green); margin-bottom: 2.5rem;">Finalizar Pedido</h1>

            @if($errors->any())
                <div style="background: #fff5f5; border-left: 4px solid #fa5252; color: #c92a2a; padding: 1.25rem; border-radius: 0.75rem; margin-bottom: 2.25rem; font-family: var(--fuente-sans); font-size: 0.9rem; box-shadow: 0 4px 10px rgba(0,0,0,0.02);">
                    <div style="font-weight: bold; margin-bottom: 0.5rem;"><i class="fa-solid fa-triangle-exclamation"></i> Por favor corrige los siguientes errores:</div>
                    <ul style="margin: 0; padding-left: 1.25rem; line-height: 1.5;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="checkoutForm">
                @csrf
                <div class="checkout-layout">
                    <!-- Form sections -->
                    <div>
                        <!-- Shipping Info -->
                        <div class="checkout-form-section" style="margin-bottom: 2rem;">
                            <h2 class="checkout-title">
                                <i class="fa-solid fa-map-location-dot" style="opacity: 0.8;"></i> 1. Información de Entrega
                            </h2>

                            <!-- Formulario para Recogida en Tienda -->
                            <div id="storePickupForm" class="form-group-grid" style="display: none;">
                                <div style="grid-column: span 2; margin-bottom: 1rem;">
                                    <p style="color: var(--brand-accent); font-size: 0.9rem; margin-bottom: 1rem;">
                                        <i class="fa-solid fa-store"></i> Recogerás tu pedido en nuestra tienda. Solo necesitamos tu nombre y teléfono para contactarte.
                                    </p>
                                </div>
                                <div style="grid-column: span 2;">
                                    <label for="pickup_name">Nombre completo <span style="color: #fa5252;">*</span></label>
                                    <input type="text" id="pickup_name" name="pickup_name" class="input-field" placeholder="Tu nombre completo" value="{{ old('name_destination', $user->name) }}">
                                </div>
                                <div style="grid-column: span 2;">
                                    <label for="pickup_phone">Teléfono de contacto <span style="color: #fa5252;">*</span></label>
                                    <input type="text" id="pickup_phone" name="pickup_phone" class="input-field" placeholder="Ej. +34 600123456" value="{{ old('phone', $user->phone) }}">
                                </div>
                            </div>

                            <!-- Formulario para Envío a Domicilio -->
                            <div id="shippingForm" class="form-group-grid">
                                @if($direcciones->isNotEmpty())
                                <div style="grid-column: span 2; margin-bottom: 0.5rem;">
                                    <label style="margin-bottom: 0.75rem;">Elige una dirección guardada</label>
                                    <div class="checkout-address-grid" id="savedAddressGrid">
                                        @foreach($direcciones as $index => $dir)
                                            <label class="checkout-address-card {{ $index === 0 ? 'selected' : '' }}"
                                                   data-id="{{ $dir->id }}"
                                                   data-name="{{ $dir->name_destination }}"
                                                   data-address="{{ $dir->address }}"
                                                   data-city="{{ $dir->city }}"
                                                   data-postcode="{{ $dir->post_code }}"
                                                   data-country="{{ $dir->country }}"
                                                   data-phone="{{ $dir->phone }}">
                                                <input type="radio" name="saved_address_choice" value="{{ $dir->id }}" {{ $index === 0 ? 'checked' : '' }} class="checkout-address-radio">
                                                <div class="checkout-address-card-body">
                                                    <strong>{{ $dir->name_destination ?? $user->name }}</strong>
                                                    <span>{{ $dir->address }}</span>
                                                    <span>{{ $dir->post_code }} {{ $dir->city }}{{ $dir->province ? ', ' . $dir->province : '' }}</span>
                                                    <span>{{ $dir->country }}</span>
                                                    @if($dir->phone)
                                                        <span><i class="fa-solid fa-phone"></i> {{ $dir->phone }}</span>
                                                    @endif
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                    <button type="button" id="btnUseManualAddress" class="checkout-manual-address-btn">
                                        <i class="fa-solid fa-plus"></i> Usar otra dirección distinta
                                    </button>
                                </div>
                                @endif

                                <div id="manualAddressFields" class="manual-address-fields {{ $direcciones->isNotEmpty() ? 'is-collapsed' : '' }}" style="grid-column: span 2;">
                                    <div class="form-group-grid" style="margin-top: 0;">
                                <div style="grid-column: span 2;">
                                    <label for="name_destination">Receptor (Nombre y Apellidos)</label>
                                    <input type="text" id="name_destination" name="name_destination" class="input-field" placeholder="Nombre de quien recibe el paquete" value="{{ old('name_destination', $user->name) }}">
                                </div>

                                <div style="grid-column: span 2;">
                                    <label for="address">Dirección de Entrega</label>
                                    <input type="text" id="address" name="address" class="input-field" placeholder="Calle, número, piso, puerta, urbanización..." value="{{ old('address') }}">
                                </div>

                                <div style="grid-column: span 1;">
                                    <label for="city">Ciudad</label>
                                    <input type="text" id="city" name="city" class="input-field" placeholder="Ej. Madrid" value="{{ old('city') }}">
                                </div>

                                <div style="grid-column: span 1;">
                                    <label for="post_code">Código Postal</label>
                                    <input type="text" id="post_code" name="post_code" class="input-field" placeholder="Ej. 28001" value="{{ old('post_code') }}">
                                </div>

                                <div style="grid-column: span 1;">
                                    <label for="country">País</label>
                                    <input type="text" id="country" name="country" class="input-field" placeholder="Ej. España" value="{{ old('country', 'España') }}">
                                </div>

                                <div style="grid-column: span 1;">
                                    <label for="phone">Teléfono de contacto</label>
                                    <input type="text" id="phone" name="phone" class="input-field" placeholder="Ej. +34 600123456" value="{{ old('phone', $user->phone) }}">
                                </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Method -->
                        <div class="checkout-form-section" style="margin-bottom: 2rem;">
                            <h2 class="checkout-title">
                                <i class="fa-solid fa-truck" style="opacity: 0.8;"></i> 2. Método de Envío
                            </h2>
                            
                            <div class="payment-methods-list" style="display: flex; flex-direction: column; gap: 1rem;">
                                <!-- Envío Estándar -->
                                <label class="payment-method-card selected" id="label_shipping_standard">
                                    <div style="display: flex; align-items: center; gap: 1rem;">
                                        <input type="radio" name="shipping_method" value="standard" checked onchange="toggleShippingMethod(this)">
                                        <div>
                                            <span style="font-size: 0.95rem; font-weight: 600; color: var(--brand-green); display: block; margin-bottom: 0.15rem;">Envío Estándar (3-5 días hábiles)</span>
                                            <span style="font-size: 0.8rem; color: rgba(27, 48, 34, 0.6);">Entrega segura a domicilio. Gratis a partir de 50€</span>
                                        </div>
                                    </div>
                                    <span style="font-family: var(--fuente-sans); font-weight: 700; color: var(--brand-green); font-size: 1.05rem;" id="shipping_standard_price_text">
                                        {{ $subtotal >= 50 ? 'Gratis' : '4.99€' }}
                                    </span>
                                </label>
                                
                                <!-- Envío Exprés -->
                                <label class="payment-method-card" id="label_shipping_express">
                                    <div style="display: flex; align-items: center; gap: 1rem;">
                                        <input type="radio" name="shipping_method" value="express" onchange="toggleShippingMethod(this)">
                                        <div>
                                            <span style="font-size: 0.95rem; font-weight: 600; color: var(--brand-green); display: block; margin-bottom: 0.15rem;">Envío Exprés (24-48 horas)</span>
                                            <span style="font-size: 0.8rem; color: rgba(27, 48, 34, 0.6);">Procesamiento prioritario y entrega urgente.</span>
                                        </div>
                                    </div>
                                    <span style="font-family: var(--fuente-sans); font-weight: 700; color: var(--brand-green); font-size: 1.05rem;">
                                        9.99€
                                    </span>
                                </label>

                                <!-- Recogida en Tienda -->
                                <label class="payment-method-card" id="label_shipping_pickup">
                                    <div style="display: flex; align-items: center; gap: 1rem;">
                                        <input type="radio" name="shipping_method" value="store_pickup" onchange="toggleShippingMethod(this)">
                                        <div>
                                            <span style="font-size: 0.95rem; font-weight: 600; color: var(--brand-green); display: block; margin-bottom: 0.15rem;">Recogida en Tienda (Gratuito)</span>
                                            <span style="font-size: 0.8rem; color: rgba(27, 48, 34, 0.6);">Recoge tu pedido directamente en nuestra farmacia/botica local.</span>
                                        </div>
                                    </div>
                                    <span style="font-family: var(--fuente-sans); font-weight: 700; color: var(--brand-accent, #8B6F4A); font-size: 1.05rem; text-transform: uppercase;">
                                        Gratis
                                    </span>
                                </label>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="checkout-form-section" style="margin-bottom: 2rem;">
                            <h2 class="checkout-title">
                                <i class="fa-solid fa-credit-card" style="opacity: 0.8;"></i> 3. Pago y Facturación
                            </h2>
                            
                            <!-- Express Checkout (Apple Pay & Google Pay) -->
                            <div id="payment-request-button-container" style="display: none;">
                                <div id="payment-request-button">
                                    <!-- Stripe Payment Request Button will mount here -->
                                </div>
                                <div class="express-checkout-divider">
                                    <hr>
                                    <span>o pagar con tarjeta tradicional</span>
                                    <hr>
                                </div>
                            </div>
                            
                            <div style="margin-bottom: 1.5rem; display: flex; flex-direction: column; gap: 1rem;">
                                <!-- Pago Seguro por Tarjeta -->
                                <label class="payment-method-card selected" id="label_payment_card">
                                    <div style="display: flex; align-items: center; gap: 1rem;">
                                        <input type="radio" name="payment_method" value="credit_card" checked onchange="togglePaymentMethod(this)">
                                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                                            <i class="fa-solid fa-credit-card" style="color: var(--brand-green); font-size: 1.2rem;"></i>
                                            <span style="font-size: 0.95rem; font-weight: 600; color: var(--brand-green);">Tarjeta de Crédito o Débito</span>
                                        </div>
                                    </div>
                                    <div style="display: flex; gap: 0.35rem; font-size: 1.2rem; color: rgba(27, 48, 34, 0.3);">
                                        <i class="fa-brands fa-cc-visa" style="color: #1a1f71;"></i>
                                        <i class="fa-brands fa-cc-mastercard" style="color: #eb001b;"></i>
                                        <i class="fa-brands fa-cc-amex" style="color: #016fd0;"></i>
                                    </div>
                                </label>

                                <!-- Pago en Tienda -->
                                <label class="payment-method-card" id="label_payment_store">
                                    <div style="display: flex; align-items: center; gap: 1rem;">
                                        <input type="radio" name="payment_method" value="store_payment" onchange="togglePaymentMethod(this)">
                                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                                            <i class="fa-solid fa-shop" style="color: var(--brand-green); font-size: 1.2rem;"></i>
                                            <span style="font-size: 0.95rem; font-weight: 600; color: var(--brand-green);">Pago en Tienda (Efectivo / Tarjeta al recoger)</span>
                                        </div>
                                    </div>
                                    <span style="font-size: 0.8rem; color: var(--brand-accent, #8B6F4A); font-weight: 700; text-transform: uppercase;">Sin recargo</span>
                                </label>

                                <!-- Stripe Credit Card Form -->
                                <div id="stripe-card-wrapper" style="margin-top: 1rem; transition: all 0.3s ease;">
                                    <label style="font-family: var(--font-sans); font-size: 0.75rem; font-weight: 600; text-transform: uppercase; margin-bottom: 0.5rem; display: block; opacity: 0.8;">
                                        Detalles de la Tarjeta
                                    </label>
                                    <div id="card-element">
                                        <!-- Stripe Card Element will mount here -->
                                    </div>
                                    <div id="card-errors" role="alert"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Review Sidebar -->
                    <aside class="order-review-card">
                        <h3>Tu Pedido</h3>
                        
                        <div class="order-review-item-container">
                            @foreach($cart as $item)
                            <div class="order-review-item">
                                <span style="max-width: 70%; font-weight: 500;">{{ $item['name'] }} <strong style="color: var(--brand-accent); font-weight: 600;">x{{ $item['qty'] }}</strong></span>
                                <span style="font-weight: 600;">{{ number_format($item['price'] * $item['qty'], 2) }}€</span>
                            </div>
                            @endforeach
                        </div>

                        <div class="order-review-totals">
                            <div class="order-review-row">
                                <span>Subtotal</span>
                                <span>{{ number_format($subtotal, 2) }}€</span>
                            </div>

                            @if(isset($discount) && $discount > 0)
                            <div class="order-review-row" style="color: #0d9488; font-weight: 700; background: rgba(13, 148, 136, 0.05); padding: 0.65rem 0.85rem; border-radius: 0.75rem; border: 1px dashed rgba(13, 148, 136, 0.2); display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                                <span style="display: inline-flex; align-items: center; gap: 0.4rem; color: #0f766e;"><i class="fa-solid fa-gift" style="color: var(--brand-accent, #8B6F4A); font-size: 0.95rem;"></i> Descuento (Cupón)</span>
                                <span>-{{ number_format($discount, 2) }}€</span>
                            </div>
                            @endif

                            <div class="order-review-row">
                                <span>Gastos de Envío</span>
                                <span id="shipping-cost-value" style="font-weight: 600; color: {{ $subtotalAfterDiscount >= 50 ? 'var(--brand-accent)' : 'var(--brand-green)' }}">
                                    {{ $subtotalAfterDiscount >= 50 ? 'Gratis' : number_format(4.99, 2) . '€' }}
                                </span>
                            </div>
                            <div class="order-review-row total-row">
                                <span>TOTAL</span>
                                <span id="grand-total-value">{{ number_format($subtotalAfterDiscount >= 50 ? $subtotalAfterDiscount : $subtotalAfterDiscount + 4.99, 2) }}€</span>
                            </div>
                        </div>

                        <button type="submit" class="btn-submit-checkout" id="btnSubmitCheckout">
                            <i class="fa-solid fa-lock" style="font-size: 0.9rem;"></i> Confirmar y Pagar
                        </button>
                        
                        <p style="font-family: var(--fuente-sans); font-size: 0.75rem; text-align: center; color: rgba(27, 48, 34, 0.5); line-height: 1.4; margin-top: 1.25rem; margin-bottom: 0;">
                            <i class="fa-solid fa-shield-halved" style="color: #2b8a3e; margin-right: 0.25rem;"></i> Pago 100% encriptado y protegido mediante el protocolo de seguridad SSL de Stripe.
                        </p>
                    </aside>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
    // 1. Inicialización de Stripe Elements
    const stripe = Stripe("{{ $stripeKey }}");
    const elements = stripe.elements();
    
    // Configuración estética de Stripe que hereda el tema del proyecto
    const style = {
        base: {
            color: '#1b3022',
            fontFamily: 'Outfit, var(--fuente-sans), sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '15px',
            '::placeholder': {
                color: 'rgba(27, 48, 34, 0.4)'
            }
        },
        invalid: {
            color: '#e53e3e',
            iconColor: '#e53e3e'
        }
    };
    
    const card = elements.create('card', { style: style, hidePostalCode: true });
    card.mount('#card-element');
    
    card.on('change', function(event) {
        const displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> ' + event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    // A. Configurar Stripe Payment Request (Apple Pay / Google Pay)
    let finalAmountCents = Math.round({{ $subtotalAfterDiscount >= 50 ? $subtotalAfterDiscount : $subtotalAfterDiscount + 4.99 }} * 100);
    
    const paymentRequest = stripe.paymentRequest({
        country: 'ES',
        currency: 'eur',
        total: {
            label: 'Total de tu compra',
            amount: finalAmountCents,
        },
        requestPayerName: true,
        requestPayerEmail: true,
        requestPayerPhone: true,
    });

    const prButton = elements.create('paymentRequestButton', {
        paymentRequest: paymentRequest,
        style: {
            paymentRequestButton: {
                theme: 'dark',
                height: '48px',
            },
        },
    });

    // Comprobar si Apple Pay o Google Pay están disponibles
    paymentRequest.canMakePayment().then(function(result) {
        if (result) {
            prButton.mount('#payment-request-button');
            document.getElementById('payment-request-button-container').style.display = 'block';
        } else {
            document.getElementById('payment-request-button-container').style.display = 'none';
        }
    });

    // B. Procesar cobro con el monedero digital (Apple Pay / Google Pay)
    paymentRequest.on('paymentmethod', async function(ev) {
        const name = ev.payerName || document.getElementById('name_destination').value || 'Cliente';
        const email = ev.payerEmail || "{{ $user->email }}";
        const phone = ev.payerPhone || document.getElementById('phone').value || '';
        
        const shippingPayload = getShippingPayload();

        if (!validateShippingPayload(shippingPayload)) {
            ev.complete('fail');
            Swal.fire({
                icon: 'warning',
                title: 'Dirección Requerida',
                text: 'Por favor, elige una dirección guardada o rellena tu dirección de envío en el paso 1.',
                confirmButtonColor: '#1b3022'
            });
            return;
        }

        try {
            // Fase 1: Pre-registrar pedido en backend
            const prepareResponse = await fetch("{{ route('cart.preparePayment') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    ...shippingPayload,
                    payment_method: 'credit_card'
                })
            });

            const prepareData = await prepareResponse.json();

            if (!prepareResponse.ok || prepareData.error) {
                throw new Error(prepareData.error || "Error al preparar el pago.");
            }

            const clientSecret = prepareData.client_secret;
            const paymentIntentId = prepareData.payment_intent_id;
            const orderId = prepareData.order_id;

            // Fase 2: Confirmar en Stripe
            const { paymentIntent, error: confirmError } = await stripe.confirmCardPayment(
                clientSecret,
                { payment_method: ev.paymentMethod.id },
                { handleActions: false }
            );

            if (confirmError) {
                ev.complete('fail');
                throw new Error(confirmError.message);
            }

            ev.complete('success');

            // Si requiere SCA
            if (paymentIntent.status === "requires_action") {
                const { error: handleActionError } = await stripe.confirmCardPayment(clientSecret);
                if (handleActionError) {
                    throw new Error(handleActionError.message);
                }
            }

            // Fase 3: Confirmar en backend
            const confirmResponse = await fetch("{{ route('cart.confirmPayment') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    order_id: orderId,
                    payment_intent_id: paymentIntentId
                })
            });

            const confirmData = await confirmResponse.json();

            if (confirmResponse.ok && confirmData.success) {
                window.location.href = confirmData.redirect;
            } else {
                throw new Error(confirmData.error || "La confirmación del pedido falló.");
            }

        } catch (error) {
            console.error("Error en Express Checkout: ", error);
            Swal.fire({
                icon: 'error',
                title: 'Error en el Pago',
                text: error.message,
                confirmButtonColor: '#1b3022'
            });
        }
    });

    // 2. Direcciones guardadas y formulario manual
    let selectedAddressId = null;
    const savedAddressGrid = document.getElementById('savedAddressGrid');
    const manualAddressFields = document.getElementById('manualAddressFields');
    const btnUseManualAddress = document.getElementById('btnUseManualAddress');

    function fillAddressFromCard(card) {
        if (!card) return;

        document.getElementById('name_destination').value = card.dataset.name || '';
        document.getElementById('address').value = card.dataset.address || '';
        document.getElementById('city').value = card.dataset.city || '';
        document.getElementById('post_code').value = card.dataset.postcode || '';
        document.getElementById('country').value = card.dataset.country || '';
        document.getElementById('phone').value = card.dataset.phone || '';
    }

    function selectSavedAddressCard(card) {
        if (!savedAddressGrid || !card) return;

        selectedAddressId = card.dataset.id;
        savedAddressGrid.querySelectorAll('.checkout-address-card').forEach(item => item.classList.remove('selected'));
        card.classList.add('selected');
        const radio = card.querySelector('.checkout-address-radio');
        if (radio) radio.checked = true;
        fillAddressFromCard(card);

        if (manualAddressFields) {
            manualAddressFields.classList.add('is-collapsed');
        }
    }

    function enableManualAddressMode() {
        selectedAddressId = null;
        if (savedAddressGrid) {
            savedAddressGrid.querySelectorAll('.checkout-address-card').forEach(item => item.classList.remove('selected'));
            savedAddressGrid.querySelectorAll('.checkout-address-radio').forEach(radio => radio.checked = false);
        }
        if (manualAddressFields) {
            manualAddressFields.classList.remove('is-collapsed');
        }
        document.getElementById('name_destination').value = '';
        document.getElementById('address').value = '';
        document.getElementById('city').value = '';
        document.getElementById('post_code').value = '';
        document.getElementById('country').value = 'España';
        document.getElementById('phone').value = '';
        document.getElementById('name_destination').focus();
    }

    if (savedAddressGrid) {
        savedAddressGrid.querySelectorAll('.checkout-address-card').forEach(card => {
            card.addEventListener('click', () => selectSavedAddressCard(card));
        });

        const initialCard = savedAddressGrid.querySelector('.checkout-address-card.selected')
            || savedAddressGrid.querySelector('.checkout-address-card');
        if (initialCard) {
            selectSavedAddressCard(initialCard);
        }
    }

    if (btnUseManualAddress) {
        btnUseManualAddress.addEventListener('click', enableManualAddressMode);
    }

    function getShippingPayload() {
        const shippingMethod = document.querySelector('input[name="shipping_method"]:checked').value;
        const payload = {
            shipping_method: shippingMethod,
        };

        if (shippingMethod === 'store_pickup') {
            payload.name_destination = document.getElementById('pickup_name').value;
            payload.phone = document.getElementById('pickup_phone').value;
        } else {
            if (selectedAddressId) {
                payload.address_id = selectedAddressId;
                fillAddressFromCard(savedAddressGrid.querySelector(`[data-id="${selectedAddressId}"]`));
            } else {
                payload.name_destination = document.getElementById('name_destination').value;
                payload.address = document.getElementById('address').value;
                payload.city = document.getElementById('city').value;
                payload.post_code = document.getElementById('post_code').value;
                payload.country = document.getElementById('country').value;
                payload.phone = document.getElementById('phone').value;
            }
        }

        return payload;
    }

    function validateShippingPayload(payload) {
        const shippingMethod = document.querySelector('input[name="shipping_method"]:checked').value;

        // Si es recogida en tienda, validar nombre y teléfono
        if (shippingMethod === 'store_pickup') {
            return payload.name_destination && payload.phone;
        }

        // Si es envío a domicilio y tiene dirección guardada, validar
        if (payload.address_id) {
            return true;
        }

        // Si es envío a domicilio, validar campos de dirección
        return payload.name_destination && payload.address && payload.city && payload.post_code && payload.country;
    }

    // 3. Selección y Recálculo de Envío Dinámico
    const baseSubtotal = parseFloat("{{ $subtotalAfterDiscount }}");
    
    function toggleShippingMethod(radio) {
        document.querySelectorAll('input[name="shipping_method"]').forEach(input => {
            const card = input.closest('.payment-method-card');
            if (card) card.classList.remove('selected');
        });

        const selectedCard = radio.closest('.payment-method-card');
        if (selectedCard) selectedCard.classList.add('selected');

        // Mostrar/ocultar formularios según método de envío
        const storePickupForm = document.getElementById('storePickupForm');
        const shippingForm = document.getElementById('shippingForm');
        const isStorePickup = radio.value === 'store_pickup';

        if (isStorePickup) {
            storePickupForm.style.display = 'block';
            shippingForm.style.display = 'none';

            // Seleccionar automáticamente pago en tienda
            const storePaymentRadio = document.querySelector('input[name="payment_method"][value="store_payment"]');
            if (storePaymentRadio) {
                storePaymentRadio.checked = true;
                togglePaymentMethod(storePaymentRadio);
            }
        } else {
            storePickupForm.style.display = 'none';
            shippingForm.style.display = 'block';

            // Seleccionar automáticamente tarjeta bancaria
            const creditCardRadio = document.querySelector('input[name="payment_method"][value="credit_card"]');
            if (creditCardRadio) {
                creditCardRadio.checked = true;
                togglePaymentMethod(creditCardRadio);
            }
        }

        recalculateTotals();
    }

    function togglePaymentMethod(radio) {
        document.querySelectorAll('input[name="payment_method"]').forEach(input => {
            const card = input.closest('.payment-method-card');
            if (card) card.classList.remove('selected');
        });
        
        const selectedCard = radio.closest('.payment-method-card');
        if (selectedCard) selectedCard.classList.add('selected');
        
        const stripeWrapper = document.getElementById('stripe-card-wrapper');
        if (radio.value === 'store_payment') {
            stripeWrapper.style.opacity = '0';
            setTimeout(() => { stripeWrapper.style.display = 'none'; }, 300);
        } else {
            stripeWrapper.style.display = 'block';
            setTimeout(() => { stripeWrapper.style.opacity = '1'; }, 50);
        }
    }
    
    function recalculateTotals() {
        const shippingMethod = document.querySelector('input[name="shipping_method"]:checked').value;
        let shippingCost = 0.00;
        
        if (shippingMethod === 'standard') {
            shippingCost = baseSubtotal >= 50.00 ? 0.00 : 4.99;
        } else if (shippingMethod === 'express') {
            shippingCost = 9.99;
        } else if (shippingMethod === 'store_pickup') {
            shippingCost = 0.00;
        }
        
        // Actualizar el costo de envío en el DOM
        const shippingRowValue = document.getElementById('shipping-cost-value');
        if (shippingCost === 0.00) {
            shippingRowValue.textContent = 'Gratis';
            shippingRowValue.style.color = 'var(--brand-accent)';
        } else {
            shippingRowValue.textContent = shippingCost.toFixed(2) + '€';
            shippingRowValue.style.color = 'var(--brand-green)';
        }
        
        // Actualizar el total general en el DOM
        const finalTotal = baseSubtotal + shippingCost;
        document.getElementById('grand-total-value').textContent = finalTotal.toFixed(2) + '€';

        // C. Actualizar dinámicamente el total del monedero digital
        if (paymentRequest) {
            paymentRequest.update({
                total: {
                    label: 'Total de tu compra',
                    amount: Math.round(finalTotal * 100),
                }
            });
        }
    }

    // 4. Intercepción del formulario y procesamiento AJAX del cobro
    const form = document.getElementById('checkoutForm');
    const submitBtn = document.getElementById('btnSubmitCheckout');
    
    form.addEventListener('submit', async function(event) {
        event.preventDefault();
        
        const paymentRadio = document.querySelector('input[name="payment_method"]:checked');
        const payment_method = paymentRadio ? paymentRadio.value : 'credit_card';
        const isStorePayment = (payment_method === 'store_payment');
        const shippingPayload = getShippingPayload();

        if (!validateShippingPayload(shippingPayload)) {
            const shippingMethod = document.querySelector('input[name="shipping_method"]:checked').value;
            if (shippingMethod === 'store_pickup') {
                document.getElementById('card-errors').innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> Para recoger en tienda no es necesario completar la dirección de envío.';
            } else {
                document.getElementById('card-errors').innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> Debes elegir o completar una dirección de envío para envío a domicilio.';
            }
            return;
        }
        
        // Bloquear botón e indicar cargando
        submitBtn.disabled = true;
        submitBtn.innerHTML = isStorePayment 
            ? '<i class="fa-solid fa-spinner fa-spin"></i> PROCESANDO PEDIDO...'
            : '<i class="fa-solid fa-spinner fa-spin"></i> PROCESANDO PAGO...';
        
        const name = document.getElementById('name_destination').value;
        const address = document.getElementById('address').value;
        const city = document.getElementById('city').value;
        const postcode = document.getElementById('post_code').value;
        const country = document.getElementById('country').value;
        const phone = document.getElementById('phone').value;
        
        try {
            // Fase 1: Pre-registrar el pedido
            const prepareResponse = await fetch("{{ route('cart.preparePayment') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    ...shippingPayload,
                    payment_method: payment_method
                })
            });
            
            const prepareData = await prepareResponse.json();
            
            if (!prepareResponse.ok || prepareData.error) {
                throw new Error(prepareData.error || prepareData.message || "Error al preparar tu pedido.");
            }
            
            // Si es Pago en Tienda, redirigir directamente
            if (prepareData.is_store_payment) {
                window.location.href = prepareData.redirect;
                return;
            }
            
            const clientSecret = prepareData.client_secret;
            const paymentIntentId = prepareData.payment_intent_id;
            const orderId = prepareData.order_id;
            
            // Fase 2: Confirmar el pago seguro con tarjeta en Stripe Elements (Maneja SCA/3D Secure)
            const stripeResult = await stripe.confirmCardPayment(clientSecret, {
                payment_method: {
                    card: card,
                    billing_details: {
                        name: name,
                        phone: phone || undefined,
                        address: {
                            line1: address,
                            city: city,
                            postal_code: postcode,
                            country: 'ES' // Código de país por defecto
                        }
                    }
                }
            });
            
            if (stripeResult.error) {
                throw new Error(stripeResult.error.message);
            }
            
            // Fase 3: Confirmar la validez del cobro en el backend
            if (stripeResult.paymentIntent.status === 'succeeded') {
                const confirmResponse = await fetch("{{ route('cart.confirmPayment') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        order_id: orderId,
                        payment_intent_id: paymentIntentId
                    })
                });
                
                const confirmData = await confirmResponse.json();
                
                if (confirmResponse.ok && confirmData.success) {
                    // Redirección de éxito
                    window.location.href = confirmData.redirect;
                } else {
                    throw new Error(confirmData.error || "El pago se realizó, pero la validación interna falló.");
                }
            } else {
                throw new Error("El pago no ha sido autorizado con éxito por tu entidad bancaria.");
            }
            
        } catch (error) {
            console.error("Error en Checkout: ", error);
            const errorElement = document.getElementById('card-errors');
            errorElement.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> ' + error.message;
            
            // Reactivar el botón para reintentos
            submitBtn.disabled = false;
            submitBtn.innerHTML = isStorePayment
                ? '<i class="fa-solid fa-check-circle"></i> Confirmar Pedido'
                : '<i class="fa-solid fa-lock"></i> Confirmar y Pagar';
        }
    });

    // Inicializar estado de la sección de dirección según el método de envío seleccionado
    document.addEventListener('DOMContentLoaded', function() {
        const selectedShippingMethod = document.querySelector('input[name="shipping_method"]:checked');
        if (selectedShippingMethod) {
            toggleShippingMethod(selectedShippingMethod);
        }
    });
</script>
@endpush
