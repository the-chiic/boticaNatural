@extends('landingPage')

@push('style')
    <link rel="stylesheet" href="{{ asset('css/styleShow.css') }}">
@endpush

@section('main_content')
    <div class="section-padding" style="background: white;">
        <div class="container">
            <!-- Breadcrumbs -->
            <div class="mb-8" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em; color: rgba(27, 48, 34, 0.4);">
                <a href="/">Inicio</a> / <a href="/catalogo">Catálogo</a> / <span style="color: var(--brand-green);">Aceite de Eucalipto</span>
            </div>

            <div class="product-show-layout">
                <!-- Image -->
                <div class="product-gallery">
                    <img src="{{ asset('img/imgPrueba.png') }}" class="main-image" alt="Aceite de Eucalipto">
                </div>



                <!-- Info -->
                <div class="product-info-panel">
                    <span class="product-category-tag">Aceites Esenciales</span>
                    <h1 class="product-title-large">ACEITE DE EUCALIPTO PURO</h1>
                    <span class="product-price-large">18.90€</span>

                    <p class="product-description">
                        Nuestro aceite esencial de eucalipto es 100% puro y natural, obtenido mediante destilación al vapor. Ideal para aromaterapia, ayuda a despejar las vías respiratorias y aporta una sensación de frescura y energía renovada a tu hogar.
                    </p>


                    <div class="purchase-actions">
                        <div class="quantity-selector">
                            <button class="qty-btn" id="minus">-</button>
                            <input type="number" value="1" class="qty-input" id="qty">
                            <button class="qty-btn" id="plus">+</button>
                        </div>
                        <button class="btn-primary" style="flex: 1; padding: 1.25rem;">
                            AÑADIR AL CARRITO
                        </button>
                    </div>

                    <div class="benefits-grid">
                        <div class="benefit-item">
                            <div class="benefit-icon"><i class="fas fa-leaf"></i></div>
                            <span>100% Orgánico</span>
                        </div>
                        <div class="benefit-item">
                            <div class="benefit-icon"><i class="fas fa-moon"></i></div>
                            <span>Ayuda al sueño</span>
                        </div>
                        <div class="benefit-item">
                            <div class="benefit-icon"><i class="fas fa-shipping-fast"></i></div>
                            <span>Envío 24/48h</span>
                        </div>
                        <div class="benefit-item">
                            <div class="benefit-icon"><i class="fas fa-undo"></i></div>
                            <span>Devolución fácil</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products (reuse home grid) -->
    <section class="section-padding" style="background: var(--brand-cream);">
        <div class="container">
            <h2 class="section-title text-center mb-8">TAMBIÉN TE PUEDE GUSTAR</h2>
            <div class="title-line"></div>
            
            <div class="product-grid" style="margin-top: 4rem;">
                <!-- Product clones for demo -->
                @php
                    $related = [
                        ['id' => 2, 'name' => 'Aceite de Eucalipto', 'price' => '18.90€', 'img' => 'https://images.unsplash.com/photo-1611080626919-7cf5a9dbab5b?auto=format&fit=crop&q=80&w=600'],
                        ['id' => 3, 'name' => 'Jabón de Caléndula', 'price' => '8.00€', 'img' => 'https://images.unsplash.com/photo-1600857062241-98e5dba7f214?auto=format&fit=crop&q=80&w=600'],
                        ['id' => 4, 'name' => 'Bálsamo de Karité', 'price' => '15.75€', 'img' => 'https://images.unsplash.com/photo-1612817288484-6f916006741a?auto=format&fit=crop&q=80&w=600'],
                        ['id' => 5, 'name' => 'Aceite de Menta', 'price' => '14.20€', 'img' => 'https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?auto=format&fit=crop&q=80&w=800'],
                    ];
                @endphp

                @foreach($related as $product)
                <div class="product-card">
                    <a href="/producto/{{ $product['id'] }}">
                        <div class="product-img">
                            <img src="{{ $product['img'] }}" alt="{{ $product['name'] }}">
                        </div>
                    </a>
                    <div class="product-details">
                        <h4 style="font-weight: bold; font-size: 1.125rem; margin-bottom: 1rem;">
                            <a href="/producto/{{ $product['id'] }}">{{ $product['name'] }}</a>
                        </h4>
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <span style="font-size: 1.25rem; font-weight: 300;">{{ $product['price'] }}</span>
                            <button class="btn-primary" style="padding: 0.5rem 1rem; font-size: 0.75rem; border-radius: 0.5rem;">
                                Añadir
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('js/jsShow.js') }}"></script>
@endpush
