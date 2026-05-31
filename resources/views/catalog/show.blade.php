@extends('landingPage')

@push('style')
    <link rel="stylesheet" href="{{ asset('css/styleShow.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styleCatalog.css') }}">
@endpush

@section('main_content')
    <style>
        /* Force CSS carousel overrides directly inline in the body */
        .main-image-carousel-container {
            position: relative !important;
            overflow: hidden !important;
            border-radius: 2rem !important;
            box-shadow: 0 20px 40px rgba(27, 48, 34, 0.08) !important;
            background-color: #f7f6f2 !important;
            width: 100% !important;
            aspect-ratio: 1 / 1 !important;
        }

        .main-image-slider {
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: nowrap !important;
            transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1) !important;
            width: 100% !important;
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .main-image-slide {
            width: 100% !important;
            min-width: 100% !important;
            max-width: 100% !important;
            height: 100% !important;
            flex-shrink: 0 !important;
            object-fit: cover !important;
            display: block !important;
        }

        .gallery-carousel-btn {
            position: absolute !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            z-index: 10 !important;
            width: 2.75rem !important;
            height: 2.75rem !important;
            border-radius: 50% !important;
            border: none !important;
            cursor: pointer !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            background: rgba(255, 255, 255, 0.9) !important;
            backdrop-filter: blur(4px) !important;
            -webkit-backdrop-filter: blur(4px) !important;
            color: var(--brand-green, #1b3022) !important;
            font-size: 0.85rem !important;
            box-shadow: 0 4px 12px rgba(27, 48, 34, 0.12) !important;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1) !important;
        }

        .gallery-carousel-btn:hover {
            background: #ffffff !important;
            box-shadow: 0 6px 20px rgba(27, 48, 34, 0.2) !important;
            transform: translateY(-50%) scale(1.08) !important;
        }

        .gallery-carousel-btn.prev {
            left: 1rem !important;
        }

        .gallery-carousel-btn.next {
            right: 1rem !important;
        }

        .thumbnails-container {
            display: flex !important;
            gap: 1rem !important;
            margin-top: 1.25rem !important;
            justify-content: flex-start !important;
            flex-wrap: wrap !important;
        }

        .thumbnail-item {
            width: 5.5rem !important;
            height: 5.5rem !important;
            border-radius: 1rem !important;
            overflow: hidden !important;
            cursor: pointer !important;
            border: 2px solid transparent !important;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1) !important;
            background-color: #f7f6f2 !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.02) !important;
        }

        .thumbnail-item img {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1) !important;
            display: block !important;
        }

        .thumbnail-item:hover img {
            transform: scale(1.08) !important;
        }

        .thumbnail-item.active {
            border-color: #6b7f5a !important;
            box-shadow: 0 6px 16px rgba(107, 127, 90, 0.15) !important;
            transform: translateY(-2px) !important;
        }
    </style>

    <script>
        // Force slide active logic to override cached functions
        var currentSlideIndex = 0;

        function slideGallery(direction) {
            const slides = document.querySelectorAll('.main-image-slide');
            if (slides.length <= 1) return;

            currentSlideIndex += direction;
            if (currentSlideIndex >= slides.length) {
                currentSlideIndex = 0;
            } else if (currentSlideIndex < 0) {
                currentSlideIndex = slides.length - 1;
            }

            updateActiveSlide();
        }

        function jumpToGalleryImage(index, thumbnailEl) {
            currentSlideIndex = index;
            updateActiveSlide();
        }

        function updateActiveSlide() {
            const slider = document.getElementById('imageSlider');
            const slides = document.querySelectorAll('.main-image-slide');
            const thumbnails = document.querySelectorAll('.thumbnail-item');

            if (slider && slides.length > 0) {
                slider.style.transform = `translateX(-${currentSlideIndex * 100}%)`;
            }

            thumbnails.forEach((thumb, idx) => {
                thumb.classList.toggle('active', idx === currentSlideIndex);
            });
        }

        // Initialize active state on load
        document.addEventListener('DOMContentLoaded', function() {
            updateActiveSlide();
        });
    </script>
    <div class="section-padding" style="background: white; padding-top: 4rem;">
        <div class="container">
            <!-- Breadcrumbs -->
            <div class="mb-8" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em; color: rgba(27, 48, 34, 0.4);">
                <a href="{{ url('/') }}">Inicio</a> / <a href="{{ route('catalog.index') }}">Catálogo</a> / <span style="color: var(--brand-green); font-weight: 500;">{{ $product->name }}</span>
            </div>

            @if(session('success'))
                <div class="alert alert-success mb-4" style="background: rgba(76, 175, 80, 0.12); color: var(--brand-green); padding: 0.75rem 1rem; border-radius: 0.5rem; font-family: var(--fuente-sans);">
                    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                </div>
            @endif

            <div class="product-show-layout">
                <!-- Image Gallery Carousel -->
                <div class="product-gallery">
                    <div class="main-image-carousel-container">
                        @if(count($product->gallery_images) > 1)
                            <button type="button" class="gallery-carousel-btn prev" onclick="slideGallery(-1)" aria-label="Anterior">
                                <i class="fa-solid fa-chevron-left"></i>
                            </button>
                        @endif
                        
                        <div class="main-image-slider" id="imageSlider">
                            @foreach($product->gallery_images as $index => $imgUrl)
                                <img src="{{ $imgUrl }}" class="main-image-slide {{ $index === 0 ? 'active' : '' }}" alt="{{ $product->name }} {{ $index + 1 }}">
                            @endforeach
                        </div>
                        
                        @if(count($product->gallery_images) > 1)
                            <button type="button" class="gallery-carousel-btn next" onclick="slideGallery(1)" aria-label="Siguiente">
                                <i class="fa-solid fa-chevron-right"></i>
                            </button>
                        @endif
                    </div>
                    
                    @if(count($product->gallery_images) > 1)
                        <div class="thumbnails-container">
                            @foreach($product->gallery_images as $index => $imgUrl)
                                <div class="thumbnail-item {{ $index === 0 ? 'active' : '' }}" onclick="jumpToGalleryImage({{ $index }}, this)">
                                    <img src="{{ $imgUrl }}" alt="{{ $product->name }} {{ $index + 1 }}" loading="lazy" decoding="async">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Info -->
                <div class="product-info-panel">
                    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; margin-bottom: 0.8rem; border-bottom: 1px solid rgba(27,48,34,0.05); padding-bottom: 0.5rem;">
                        <span class="product-category-tag" style="font-family: var(--fuente-sans); margin-bottom: 0;">{{ $product->categories->first()->name ?? 'Sin categoría' }}</span>
                        @if($product->stock > 10)
                            <span class="stock-badge stock-in-stock" style="font-family: var(--fuente-sans);"><span class="dot"></span> EN STOCK - Listo para envío</span>
                        @elseif($product->stock > 0)
                            <span class="stock-badge stock-low" style="font-family: var(--fuente-sans);"><span class="dot"></span> ÚLTIMAS UNIDADES - Quedan {{ $product->stock }}</span>
                        @else
                            <span class="stock-badge stock-out" style="font-family: var(--fuente-sans);"><span class="dot"></span> TEMPORALMENTE AGOTADO</span>
                        @endif
                    </div>
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

                    <div id="stockError" style="display: none; background-color: #fee; border: 1px solid #fcc; border-radius: 8px; padding: 12px 16px; margin-bottom: 1rem; color: #c33; font-size: 14px; font-family: var(--fuente-sans);">
                        <i class="fa-solid fa-circle-exclamation" style="margin-right: 8px;"></i>
                        <span id="stockErrorMessage"></span>
                    </div>

                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="purchase-actions" style="display: flex; gap: 1rem; width: 100%; margin-bottom: 2rem; border: none; background: transparent; padding: 0;" id="cartForm">
                        @csrf
                        <div class="quantity-selector">
                            <button type="button" class="qty-btn" id="minus">-</button>
                            <input type="number" name="qty" value="1" min="1" class="qty-input" id="qty" data-max-stock="{{ $product->stock }}">
                            <button type="button" class="qty-btn" id="plus">+</button>
                        </div>
                        <button type="submit" class="btn-primary" style="flex: 1; padding: 1.25rem; font-family: var(--fuente-sans); border: none; cursor: pointer; text-align: center; text-transform: uppercase; font-weight: 600; font-size: 0.85rem; letter-spacing: 0.08em; border-radius: 9999px;">
                            Añadir al Carrito
                        </button>
                    </form>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const cartForm = document.getElementById('cartForm');
                            const stockError = document.getElementById('stockError');
                            const stockErrorMessage = document.getElementById('stockErrorMessage');

                            if (cartForm) {
                                cartForm.addEventListener('submit', function(event) {
                                    const qtyInput = document.getElementById('qty');
                                    if (!qtyInput) return true;

                                    const maxStock = parseInt(qtyInput.getAttribute('data-max-stock')) || 9999;
                                    const qty = parseInt(qtyInput.value) || 0;

                                    if (qty > maxStock) {
                                        event.preventDefault();
                                        stockErrorMessage.textContent = 'La cantidad seleccionada es superior al stock restante. Solo quedan ' + maxStock + ' unidades disponibles.';
                                        stockError.style.display = 'block';
                                        qtyInput.value = maxStock;
                                        qtyInput.focus();
                                        return false;
                                    }

                                    // Ocultar el error si la validación pasa
                                    stockError.style.display = 'none';
                                    return true;
                                });
                            }
                        });
                    </script>

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

                    <!-- Accordion FAQ Widget -->
                    <div class="faq-accordion" style="margin-top: 3.5rem; font-family: var(--fuente-sans);">
                        <div class="accordion-item">
                            <button type="button" class="accordion-header" onclick="toggleAccordion(this)">
                                <span><i class="fa-solid fa-truck-fast" style="margin-right: 8px; color: var(--brand-green);"></i> Envío y Entregas</span>
                                <i class="fa-solid fa-chevron-down accordion-arrow"></i>
                            </button>
                            <div class="accordion-content">
                                <p>Nuestros preparados botánicos y elixires se embalan de forma individual y cuidadosa en envases biodegradables y paja protectora natural. Realizamos envíos urgentes a toda España con entrega garantizada en 24/48 horas laborables.</p>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <button type="button" class="accordion-header" onclick="toggleAccordion(this)">
                                <span><i class="fa-solid fa-circle-question" style="margin-right: 8px; color: var(--brand-green);"></i> Conservación Botánica</span>
                                <i class="fa-solid fa-chevron-down accordion-arrow"></i>
                            </button>
                            <div class="accordion-content">
                                <p>Al estar elaborados de forma artesanal y con ingredientes 100% ecológicos sin conservantes químicos sintéticos, aconsejamos mantener los productos en un sitio fresco y protegidos de la luz solar directa para preservar todas sus propiedades y frescura.</p>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <button type="button" class="accordion-header" onclick="toggleAccordion(this)">
                                <span><i class="fa-solid fa-shield-halved" style="margin-right: 8px; color: var(--brand-green);"></i> Garantía de Pureza Orgánica</span>
                                <i class="fa-solid fa-chevron-down accordion-arrow"></i>
                            </button>
                            <div class="accordion-content">
                                <p>Colaboramos directamente con agricultores y destiladores de comercio justo que cuentan con sellos de agricultura ecológica certificada. Todos nuestros aceites y preparados se formulan de forma consciente y respetuosa con el medio ambiente.</p>
                            </div>
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
                            <img src="{{ $related->image_url }}" alt="{{ $related->name }}" loading="lazy" decoding="async">
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
