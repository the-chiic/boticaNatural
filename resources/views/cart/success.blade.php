@extends('landingPage')

@push('style')
    <style>
        @keyframes scaleUp {
            0% { transform: scale(0.8); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
        @keyframes drawCheck {
            0% { stroke-dashoffset: 48; }
            100% { stroke-dashoffset: 0; }
        }
        
        .success-container {
            max-width: 680px;
            margin: 0 auto;
            animation: scaleUp 0.6s cubic-bezier(0.165, 0.84, 0.44, 1) both;
        }

        .success-checkmark-wrapper {
            width: 80px;
            height: 80px;
            background: #eafaf1;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            border: 1px solid rgba(43, 138, 62, 0.1);
        }

        .success-checkmark-wrapper svg {
            width: 40px;
            height: 40px;
            stroke: #2b8a3e;
            stroke-width: 4;
            stroke-linecap: round;
            stroke-linejoin: round;
            fill: none;
            stroke-dasharray: 48;
            stroke-dashoffset: 48;
            animation: drawCheck 0.6s 0.2s cubic-bezier(0.65, 0, 0.45, 1) forwards;
        }

        .receipt-card {
            background: #ffffff;
            border: 1px solid rgba(27, 48, 34, 0.05);
            border-radius: 1.5rem;
            padding: 2.5rem;
            box-shadow: var(--sombra-suave);
            margin-bottom: 2rem;
        }

        .receipt-header {
            text-align: center;
            border-bottom: 1px dashed rgba(27, 48, 34, 0.1);
            padding-bottom: 1.5rem;
            margin-bottom: 1.75rem;
        }

        .receipt-header h2 {
            font-family: var(--fuente-serif);
            font-size: 1.75rem;
            color: var(--brand-green);
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .receipt-header p {
            font-family: var(--fuente-sans);
            font-size: 0.9rem;
            color: rgba(27, 48, 34, 0.6);
            margin: 0;
        }

        .receipt-details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 2rem;
            font-family: var(--fuente-sans);
            font-size: 0.85rem;
            color: var(--brand-green);
            background: var(--brand-cream);
            padding: 1.25rem;
            border-radius: 1rem;
        }

        .receipt-details-grid div strong {
            display: block;
            font-size: 0.75rem;
            color: rgba(27, 48, 34, 0.5);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.25rem;
        }

        .receipt-items-list {
            margin-bottom: 2rem;
        }

        .receipt-item-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-family: var(--fuente-sans);
            font-size: 0.9rem;
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(27, 48, 34, 0.04);
            color: var(--brand-green);
        }

        .receipt-item-row:last-child {
            border-bottom: none;
        }

        .receipt-totals {
            border-top: 1px solid rgba(27, 48, 34, 0.08);
            padding-top: 1.25rem;
            font-family: var(--fuente-sans);
            color: var(--brand-green);
        }

        .totals-row {
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
            margin-bottom: 0.50rem;
            color: rgba(27, 48, 34, 0.7);
        }

        .totals-row.grand-total {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--brand-green);
            margin-top: 0.75rem;
            margin-bottom: 0;
        }

        .action-buttons {
            display: flex;
            gap: 1.25rem;
            justify-content: center;
            margin-top: 2.5rem;
        }

        .btn-success-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--brand-green);
            color: #ffffff;
            font-family: var(--fuente-sans);
            font-weight: 600;
            font-size: 0.9rem;
            padding: 0.9rem 1.75rem;
            border-radius: 9999px;
            text-decoration: none;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(27, 48, 34, 0.1);
        }

        .btn-success-primary:hover {
            transform: translateY(-1px);
            background: #253f2f;
            box-shadow: 0 6px 18px rgba(27, 48, 34, 0.2);
        }

        .btn-success-secondary {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: transparent;
            color: var(--brand-green);
            font-family: var(--fuente-sans);
            font-weight: 600;
            font-size: 0.9rem;
            padding: 0.9rem 1.75rem;
            border-radius: 9999px;
            text-decoration: none;
            border: 1px solid rgba(27, 48, 34, 0.2);
            transition: all 0.3s;
        }

        .btn-success-secondary:hover {
            background: rgba(27, 48, 34, 0.04);
            border-color: var(--brand-green);
        }

        /* Responsividad para móviles y tablets */
        @media (max-width: 576px) {
            .receipt-card {
                padding: 1.75rem 1.25rem;
                border-radius: 1.25rem;
            }
            .receipt-header h2 {
                font-size: 1.45rem;
            }
            .receipt-details-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
                padding: 1rem;
            }
            .action-buttons {
                flex-direction: column;
                gap: 0.85rem;
            }
            .btn-success-primary, .btn-success-secondary {
                width: 100%;
                justify-content: center;
                box-sizing: border-box;
            }
        }
    </style>
@endpush

@section('main_content')
    <div class="section-padding" style="background: var(--brand-cream); min-height: 100vh; padding-top: 5rem; padding-bottom: 6rem;">
        <div class="container">
            <div class="success-container">
                <!-- Checkmark Animation -->
                <div class="success-checkmark-wrapper">
                    <svg viewBox="0 0 24 24">
                        <path d="M20 6L9 17L4 12" />
                    </svg>
                </div>

                <!-- Receipt Card -->
                <div class="receipt-card">
                    <div class="receipt-header">
                        <h2>¡Gracias por tu compra!</h2>
                        <p>Tu pedido ha sido recibido y está siendo procesado con todo el cariño de nuestra botica.</p>
                    </div>

                    <!-- Meta details -->
                    <div class="receipt-details-grid">
                        <div>
                            <strong>Código del Pedido</strong>
                            #ORD-{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}
                        </div>
                        <div>
                            <strong>Fecha de Compra</strong>
                            {{ \Carbon\Carbon::parse($order->order_date)->translatedFormat('d \d\e F \d\e Y, H:i') }}
                        </div>
                        <div>
                            <strong>Método de Pago</strong>
                            @if($order->shipping_method === 'store_pickup' && $order->payment_method === 'store_payment')
                                <span style="display:inline-flex;align-items:center;gap:0.3rem;">
                                    <i class="fa-solid fa-store" style="color:var(--brand-accent);font-size:0.85rem;"></i>
                                    Pago en Tienda
                                </span>
                            @elseif($order->payment_method === 'store_payment')
                                <span style="display:inline-flex;align-items:center;gap:0.3rem;">
                                    <i class="fa-solid fa-store" style="color:var(--brand-accent);font-size:0.85rem;"></i>
                                    Pago en Tienda
                                </span>
                            @else
                                <span style="display:inline-flex;align-items:center;gap:0.3rem;">
                                    <i class="fa-solid fa-credit-card" style="color:var(--brand-accent);font-size:0.85rem;"></i>
                                    Tarjeta Bancaria
                                </span>
                            @endif
                        </div>
                        <div>
                            <strong>Tipo de Envío</strong>
                            @if($order->shipping_method === 'express')
                                <span style="display:inline-flex;align-items:center;gap:0.3rem;">
                                    <i class="fa-solid fa-bolt" style="color:#f59e0b;font-size:0.85rem;"></i>
                                    Exprés 24h
                                </span>
                            @elseif($order->shipping_method === 'store_pickup')
                                <span style="display:inline-flex;align-items:center;gap:0.3rem;">
                                    <i class="fa-solid fa-shop" style="color:var(--brand-accent);font-size:0.85rem;"></i>
                                    Recogida en Tienda
                                </span>
                            @else
                                <span style="display:inline-flex;align-items:center;gap:0.3rem;">
                                    <i class="fa-solid fa-truck" style="color:var(--brand-green);font-size:0.85rem;"></i>
                                    Envío Estándar
                                </span>
                            @endif
                        </div>
                        <div style="grid-column: span 2;">
                            <strong>Dirección de Envío</strong>
                            @if($order->shipping_method === 'store_pickup')
                                Recogida en tienda<br>
                                @if($order->shipping_phone)
                                    <span style="opacity: 0.8; font-size: 0.8rem; margin-top: 0.25rem; display: block;"><i class="fa-solid fa-phone" style="font-size: 0.75rem;"></i> {{ $order->shipping_phone }}</span>
                                @endif
                            @else
                                {{ $order->shipping_name }}<br>
                                {{ $order->shipping_address }}<br>
                                {{ $order->shipping_post_code }} {{ $order->shipping_city }} ({{ $order->shipping_country }})<br>
                                @if($order->shipping_phone)
                                    <span style="opacity: 0.8; font-size: 0.8rem; margin-top: 0.25rem; display: block;"><i class="fa-solid fa-phone" style="font-size: 0.75rem;"></i> {{ $order->shipping_phone }}</span>
                                @endif
                            @endif
                        </div>
                    </div>

                    <!-- Items summary -->
                    <div class="receipt-items-list">
                        <h4 style="font-family: var(--fuente-serif); color: var(--brand-green); font-size: 1.15rem; margin-bottom: 1rem; border-bottom: 1px solid rgba(27, 48, 34, 0.06); padding-bottom: 0.5rem;">Detalle de Artículos</h4>
                        @foreach($order->lines as $line)
                        <div class="receipt-item-row">
                            <div style="display: flex; flex-direction: column;">
                                <span style="font-weight: 500;">{{ $line->product->name }}</span>
                                <span style="font-size: 0.75rem; color: rgba(27, 48, 34, 0.5);">Precio unitario: {{ number_format($line->price, 2) }}€</span>
                            </div>
                            <div style="text-align: right;">
                                <span style="font-size: 0.85rem; color: rgba(27, 48, 34, 0.6); margin-right: 1rem;">x{{ $line->unit }}</span>
                                <span style="font-weight: 600;">{{ number_format($line->total_price, 2) }}€</span>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Totals -->
                    <div class="receipt-totals">
                        <div class="totals-row">
                            <span>Subtotal</span>
                            <span>{{ number_format($order->total_price - $order->shipping_cost, 2) }}€</span>
                        </div>
                        <div class="totals-row">
                            <span>Gastos de Envío ({{ $order->shipping_method === 'express' ? 'Exprés 24h' : 'Estándar' }})</span>
                            <span style="color: {{ $order->shipping_cost == 0 ? 'var(--brand-accent)' : 'inherit' }}; font-weight: {{ $order->shipping_cost == 0 ? '600' : 'normal' }}">
                                {{ $order->shipping_cost == 0 ? 'Gratis' : number_format($order->shipping_cost, 2) . '€' }}
                            </span>
                        </div>
                        <div class="totals-row grand-total">
                            <span>TOTAL PAGADO</span>
                            <span>{{ number_format($order->total_price, 2) }}€</span>
                        </div>
                    </div>
                </div>

                <!-- Action buttons -->
                <div class="action-buttons">
                    <a href="{{ route('catalog.index') }}" class="btn-success-primary">
                        <i class="fa-solid fa-bag-shopping"></i> Seguir Comprando
                    </a>
                    <a href="{{ route('profile') }}" class="btn-success-secondary">
                        <i class="fa-solid fa-user"></i> Ver mis Pedidos
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
