@extends('landingPage')

@push('style')
    <link rel="stylesheet" href="{{ asset('css/styleShow.css') }}">
@endpush

@section('main_content')
    <div class="section-padding" style="background: white;">
        <div class="container">
            <!-- Breadcrumbs -->
            <div class="mb-8" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em; color: rgba(27, 48, 34, 0.4);">
                <a href="{{ url('/') }}">Inicio</a> / <a href="{{ route('catalog.index') }}">Catálogo</a> / <span style="color: var(--brand-green);">{{ $product->name }}</span>
            </div>

            <div class="product-show-layout">
                <!-- Image -->
                <div class="product-gallery">
                    <img src="{{ asset('img/imgPrueba.png') }}" class="main-image" alt="{{ $product->name }}">
                </div>



                <!-- Info -->
                <div class="product-info-panel">
                    <span class="product-category-tag">{{ $product->categories->first()->name ?? 'Sin categoría' }}</span>
                    <h1 class="product-title-large">{{ mb_strtoupper($product->name) }}</h1>
                    <span class="product-price-large">{{ number_format($product->price, 2) }}€</span>

                    <p class="product-description">
                        @if($product->description)
                            {{ $product->description }}
                        @else
                            Descubre las maravillosas propiedades de nuestro producto <strong>{{ $product->name }}</strong>.
                            Cuidadosamente seleccionado para brindarte la mejor experiencia natural. Ideal para incorporar a tu rutina diaria y aprovechar todos los beneficios que la naturaleza tiene para ofrecerte.
                        @endif
                    </p>


                    <div class="purchase-actions">
                        <div class="quantity-selector">
                            <button class="qty-btn" id="minus">-</button>
                            <input type="number" value="1" min="1" class="qty-input" id="qty">
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
                            <div class="benefit-icon"><i class="fas fa-spa"></i></div>
                            <span>Bienestar natural</span>
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
    <section class="section-padding related-products-section" style="background: var(--brand-cream);">
        <div class="container">
            <h2 class="section-title text-center mb-8">TAMBIÉN TE PUEDE GUSTAR</h2>
            <div class="title-line"></div>
            
            <div class="product-grid related-products-grid">
                @foreach($relatedProducts as $related)
                <div class="product-card">
                    <a href="{{ route('catalog.show', $related->id) }}">
                        <div class="product-img">
                            <img src="{{ asset('img/imgPrueba.png') }}" alt="{{ $related->name }}" style="transition: transform 0.5s;">
                            <div class="product-overlay" style="position: absolute; inset: 0; background: rgba(27, 48, 34, 0.05); opacity: 0; transition: opacity 0.3s; display: flex; align-items: center; justify-content: center;">
                                <span style="background: white; color: var(--brand-green); padding: 0.5rem 1rem; border-radius: 9999px; font-size: 0.75rem; font-weight: bold;">VER DETALLE</span>
                            </div>
                        </div>
                    </a>
                    <div class="product-details">
                        <h4 style="font-weight: bold; font-size: 1.125rem; margin-bottom: 1rem;">
                            <a href="{{ route('catalog.show', $related->id) }}">{{ $related->name }}</a>
                        </h4>
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <span style="font-size: 1.25rem; font-weight: 300;">{{ number_format($related->price, 2) }}€</span>
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
