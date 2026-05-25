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
                                <i class="fa-solid fa-map-location-dot" style="opacity: 0.8;"></i> 1. Dirección de Envío
                            </h2>
                            
                            <div class="form-group-grid">
                                <!-- Address Dropdown (If customer has saved ones) -->
                                @if($direcciones->isNotEmpty())
                                <div style="grid-column: span 2; margin-bottom: 0.5rem;">
                                    <label for="saved_address">¿Usar una dirección guardada?</label>
                                    <select id="saved_address" class="input-field" onchange="fillAddress(this)" style="appearance: auto; background-image: none;">
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
                                    <label for="name_destination">Receptor (Nombre y Apellidos)</label>
                                    <input type="text" id="name_destination" name="name_destination" class="input-field" placeholder="Nombre de quien recibe el paquete" value="{{ old('name_destination', $user->name) }}" required>
                                </div>
                                
                                <div style="grid-column: span 2;">
                                    <label for="address">Dirección de Entrega</label>
                                    <input type="text" id="address" name="address" class="input-field" placeholder="Calle, número, piso, puerta, urbanización..." value="{{ old('address') }}" required>
                                </div>
                                
                                <div style="grid-column: span 1;">
                                    <label for="city">Ciudad</label>
                                    <input type="text" id="city" name="city" class="input-field" placeholder="Ej. Madrid" value="{{ old('city') }}" required>
                                </div>
                                
                                <div style="grid-column: span 1;">
                                    <label for="post_code">Código Postal</label>
                                    <input type="text" id="post_code" name="post_code" class="input-field" placeholder="Ej. 28001" value="{{ old('post_code') }}" required>
                                </div>

                                <div style="grid-column: span 1;">
                                    <label for="country">País</label>
                                    <input type="text" id="country" name="country" class="input-field" placeholder="Ej. España" value="{{ old('country', 'España') }}" required>
                                </div>

                                <div style="grid-column: span 1;">
                                    <label for="phone">Teléfono de contacto</label>
                                    <input type="text" id="phone" name="phone" class="input-field" placeholder="Ej. +34 600123456" value="{{ old('phone', $user->phone) }}">
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Method -->
                        <div class="checkout-form-section" style="margin-bottom: 2rem;">
                            <h2 class="checkout-title">
                                <i class="fa-solid fa-truck" style="opacity: 0.8;"></i> 2. Método de Envío
                            </h2>
                            
                            <div class="payment-methods-list">
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
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="checkout-form-section" style="margin-bottom: 2rem;">
                            <h2 class="checkout-title">
                                <i class="fa-solid fa-credit-card" style="opacity: 0.8;"></i> 3. Pago Seguro
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
                            
                            <div style="margin-bottom: 1.5rem;">
                                <div class="payment-method-card selected">
                                    <div style="display: flex; align-items: center; gap: 1rem;">
                                        <input type="radio" name="payment_method" value="credit_card" checked readonly>
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
                                </div>
                                    <!-- Stripe Credit Card Form -->
                             <div id="stripe-card-wrapper">
                                 <label>
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
                            <div class="order-review-row">
                                <span>Gastos de Envío</span>
                                <span id="shipping-cost-value" style="font-weight: 600; color: {{ $subtotal >= 50 ? 'var(--brand-accent)' : 'var(--brand-green)' }}">
                                    {{ $subtotal >= 50 ? 'Gratis' : number_format(4.99, 2) . '€' }}
                                </span>
                            </div>
                            <div class="order-review-row total-row">
                                <span>TOTAL</span>
                                <span id="grand-total-value">{{ number_format($subtotal >= 50 ? $subtotal : $subtotal + 4.99, 2) }}€</span>
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
    let finalAmountCents = Math.round({{ $subtotal >= 50 ? $subtotal : $subtotal + 4.99 }} * 100);
    
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
        
        const address = document.getElementById('address').value;
        const city = document.getElementById('city').value;
        const postcode = document.getElementById('post_code').value;
        const country = document.getElementById('country').value;
        const shipping_method = document.querySelector('input[name="shipping_method"]:checked').value;
        
        if (!address || !city || !postcode) {
            ev.complete('fail');
            Swal.fire({
                icon: 'warning',
                title: 'Dirección Requerida',
                text: 'Por favor, rellena tu dirección de envío en el paso 1 antes de usar Apple Pay o Google Pay para que sepamos a dónde enviar tu pedido.',
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
                    name_destination: name,
                    address: address,
                    city: city,
                    post_code: postcode,
                    country: country,
                    phone: phone,
                    shipping_method: shipping_method
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

    // 2. Autocompletado de dirección guardada
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

    // 3. Selección y Recálculo de Envío Dinámico
    const baseSubtotal = parseFloat("{{ $subtotal }}");
    
    function toggleShippingMethod(radio) {
        document.querySelectorAll('.payment-methods-list .payment-method-card').forEach(card => {
            card.classList.remove('selected');
        });
        
        const selectedCard = radio.closest('.payment-method-card');
        selectedCard.classList.add('selected');
        
        recalculateTotals();
    }
    
    function recalculateTotals() {
        const shippingMethod = document.querySelector('input[name="shipping_method"]:checked').value;
        let shippingCost = 0.00;
        
        if (shippingMethod === 'standard') {
            shippingCost = baseSubtotal >= 50.00 ? 0.00 : 4.99;
        } else if (shippingMethod === 'express') {
            shippingCost = 9.99;
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
        
        // Bloquear botón e indicar cargando
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> PROCESANDO PAGO...';
        
        const name = document.getElementById('name_destination').value;
        const address = document.getElementById('address').value;
        const city = document.getElementById('city').value;
        const postcode = document.getElementById('post_code').value;
        const country = document.getElementById('country').value;
        const phone = document.getElementById('phone').value;
        const shipping_method = document.querySelector('input[name="shipping_method"]:checked').value;
        
        try {
            // Fase 1: Pre-registrar el pedido y obtener el client_secret de Stripe
            const prepareResponse = await fetch("{{ route('cart.preparePayment') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    name_destination: name,
                    address: address,
                    city: city,
                    post_code: postcode,
                    country: country,
                    phone: phone,
                    shipping_method: shipping_method
                })
            });
            
            const prepareData = await prepareResponse.json();
            
            if (!prepareResponse.ok || prepareData.error) {
                throw new Error(prepareData.error || prepareData.message || "Error al preparar tu pedido.");
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
            submitBtn.innerHTML = '<i class="fa-solid fa-lock"></i> Confirmar y Pagar';
        }
    });
</script>
@endpush
