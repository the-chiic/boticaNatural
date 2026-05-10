@extends('landingPage')

@push('style')
    <link rel="stylesheet" href="{{ asset('css/styleCheckout.css') }}">
@endpush

@section('main_content')
    <div class="section-padding" style="background: var(--brand-cream); min-height: 100vh;">
        <div class="container">
            <h1 class="section-title mb-8">FINALIZAR PEDIDO</h1>

            <div class="checkout-layout">
                <!-- Forms -->
                <div class="checkout-form-section">
                    <section style="margin-bottom: 4rem;">
                        <h2 class="checkout-title">1. INFORMACIÓN DE ENVÍO</h2>
                        <div class="form-group-grid">
                            <div style="grid-column: span 1;">
                                <label style="font-size: 0.75rem; font-weight: bold; opacity: 0.6;">NOMBRE</label>
                                <input type="text" class="input-field" placeholder="Tu nombre">
                            </div>
                            <div style="grid-column: span 1;">
                                <label style="font-size: 0.75rem; font-weight: bold; opacity: 0.6;">APELLIDOS</label>
                                <input type="text" class="input-field" placeholder="Tus apellidos">
                            </div>
                            <div style="grid-column: span 2;">
                                <label style="font-size: 0.75rem; font-weight: bold; opacity: 0.6;">DIRECCIÓN</label>
                                <input type="text" class="input-field" placeholder="Calle, número, piso...">
                            </div>
                            <div style="grid-column: span 1;">
                                <label style="font-size: 0.75rem; font-weight: bold; opacity: 0.6;">CIUDAD</label>
                                <input type="text" class="input-field" placeholder="Madrid">
                            </div>
                            <div style="grid-column: span 1;">
                                <label style="font-size: 0.75rem; font-weight: bold; opacity: 0.6;">CÓDIGO POSTAL</label>
                                <input type="text" class="input-field" placeholder="28001">
                            </div>
                        </div>
                    </section>

                    <section>
                        <h2 class="checkout-title">2. MÉTODO DE PAGO</h2>
                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            <label class="flex items-center gap-4 p-4 border rounded-xl cursor-pointer" style="border-color: var(--brand-green); background: var(--brand-cream);">
                                <input type="radio" name="pay" checked>
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-credit-card"></i>
                                    <span style="font-size: 0.875rem; font-weight: bold;">Tarjeta de Crédito / Débito</span>
                                </div>
                            </label>
                            <label class="flex items-center gap-4 p-4 border rounded-xl cursor-pointer" style="border-color: rgba(27, 48, 34, 0.1);">
                                <input type="radio" name="pay">
                                <div class="flex items-center gap-3">
                                    <i class="fab fa-paypal"></i>
                                    <span style="font-size: 0.875rem; font-weight: bold;">PayPal</span>
                                </div>
                            </label>
                        </div>
                    </section>
                </div>

                <!-- Review -->
                <aside class="order-review-card">
                    <h3 style="font-size: 1.125rem; font-weight: 700; margin-bottom: 2rem;">TU PEDIDO</h3>
                    
                    <div style="margin-bottom: 2rem;">
                        <div class="flex justify-between mb-4" style="font-size: 0.875rem;">
                            <span>Infusión de Lavanda x1</span>
                            <span>12.50€</span>
                        </div>
                        <div class="flex justify-between mb-4" style="font-size: 0.875rem;">
                            <span>Aceite de Eucalipto x2</span>
                            <span>37.80€</span>
                        </div>
                    </div>

                    <div style="border-top: 1px solid rgba(27, 48, 34, 0.1); padding-top: 1.5rem; margin-top: 1.5rem;">
                        <div class="flex justify-between mb-2" style="font-size: 0.875rem; opacity: 0.6;">
                            <span>Subtotal</span>
                            <span>50.30€</span>
                        </div>
                        <div class="flex justify-between mb-4" style="font-size: 0.875rem; opacity: 0.6;">
                            <span>Envío</span>
                            <span>Gratis</span>
                        </div>
                        <div class="flex justify-between" style="font-size: 1.25rem; font-weight: 700; color: var(--brand-green);">
                            <span>TOTAL</span>
                            <span>50.30€</span>
                        </div>
                    </div>

                    <button class="btn-primary" style="width: 100%; margin-top: 2rem; border-radius: 1rem; padding: 1.25rem;">
                        CONFIRMAR Y PAGAR
                    </button>
                </aside>
            </div>
        </div>
    </div>
@endsection
