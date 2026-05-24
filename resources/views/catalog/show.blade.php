@extends('landingPage')

@push('style')
    <link rel="stylesheet" href="{{ asset('css/styleShow.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styleCatalog.css') }}">
@endpush

@section('main_content')
    <div class="section-padding" style="background: white; padding-top: 4rem;">
        <div class="container">
            <!-- Breadcrumbs -->
            <div class="mb-8" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em; color: rgba(27, 48, 34, 0.4);">
                <a href="{{ url('/') }}">Inicio</a> / <a href="{{ route('catalog.index') }}">Catálogo</a> / <span style="color: var(--brand-green); font-weight: 500;">{{ $product->name }}</span>
            </div>

            <div class="product-show-layout">
                <!-- Image Gallery -->
                <div class="product-gallery">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('img/imgPrueba.png') }}" class="main-image" alt="{{ $product->name }}">
                </div>

                <!-- Info -->
                <div class="product-info-panel">
                    <span class="product-category-tag" style="font-family: var(--fuente-sans);">{{ $product->categories->first()->name ?? 'Sin categoría' }}</span>
                    <h1 class="product-title-large" style="font-family: var(--fuente-serif); font-weight: 500;">{{ mb_strtoupper($product->name) }}</h1>
                    <span class="product-price-large" style="font-family: var(--fuente-sans);">{{ number_format($product->price, 2) }}€</span>

                    <p class="product-description" style="font-family: var(--fuente-sans);">
                        @if($product->description)
                            {{ $product->description }}
                        @else
                            Descubre las maravillosas propiedades de nuestro producto <strong>{{ $product->name }}</strong>.
                            Cuidadosamente seleccionado para brindarte la mejor experiencia natural. Ideal para incorporar a tu rutina diaria y aprovechar todos los beneficios que la naturaleza tiene para ofrecerte.
                        @endif
                    </p>

                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="purchase-actions" style="display: flex; gap: 1rem; width: 100%; margin-bottom: 2rem; border: none; background: transparent; padding: 0;">
                        @csrf
                        <div class="quantity-selector">
                            <button type="button" class="qty-btn" id="minus">-</button>
                            <input type="number" name="qty" value="1" min="1" class="qty-input" id="qty">
                            <button type="button" class="qty-btn" id="plus">+</button>
                        </div>
                        <button type="submit" class="btn-primary" style="flex: 1; padding: 1.25rem; font-family: var(--fuente-sans); border: none; cursor: pointer; text-align: center; text-transform: uppercase; font-weight: 600; font-size: 0.85rem; letter-spacing: 0.08em; border-radius: 9999px;">
                            Añadir al Carrito
                        </button>
                    </form>

                    <div class="benefits-grid" style="font-family: var(--fuente-sans);">
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

    <!-- Related Products -->
    <section class="section-padding related-products-section" style="background: var(--brand-cream); padding-top: 5rem; padding-bottom: 5rem;">
        <div class="container">
            <h2 class="section-title text-center mb-8" style="font-family: var(--fuente-serif); font-weight: 500; font-size: 2rem;">También te puede gustar</h2>
            <div class="title-line" style="margin-bottom: 3rem;"></div>
            
            <div class="product-grid related-products-grid">
                @foreach($relatedProducts as $related)
                <div class="product-card">
                    <a href="{{ route('catalog.show', $related->id) }}">
                        <div class="product-img">
                            <img src="{{ $related->image ? asset('storage/' . $related->image) : asset('img/imgPrueba.png') }}" alt="{{ $related->name }}">
                            <div class="product-overlay">
                                <span>Ver Detalle</span>
                            </div>
                        </div>
                    </a>
                    <div class="product-details">
                        <span style="font-size: 10px; font-weight: 600; color: rgba(27, 48, 34, 0.45); text-transform: uppercase; letter-spacing: 0.15em; display: block; margin-bottom: 0.40rem; font-family: var(--fuente-sans);">
                            {{ $related->categories->first()->name ?? 'Sin categoría' }}
                        </span>
                        <h4>
                            <a href="{{ route('catalog.show', $related->id) }}">{{ $related->name }}</a>
                        </h4>
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-top: auto;">
                            <span class="price-label">{{ number_format($related->price, 2) }}€</span>
                            <form action="{{ route('cart.add', $related->id) }}" method="POST" style="margin: 0; padding: 0; border: none; background: transparent; display: inline-flex; align-items: center;">
                                @csrf
                                <input type="hidden" name="qty" value="1">
                                <button type="submit" class="btn-primary">
                                    Añadir
                                </button>
                            </form>
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
