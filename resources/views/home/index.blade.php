@extends('landingPage')

@push('style')
    <link rel="stylesheet" href="{{ asset('css/styleHome.css') }}">
@endpush

@section('main_content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-bg">
            <img src="https://images.unsplash.com/photo-1441974231531-c6227db76b6e?auto=format&fit=crop&q=80&w=2560" alt="Bosque Natural">
            <div class="hero-overlay"></div>
        </div>

        <div class="container hero-content">
            <h1 class="hero-title">
                CUIDA TU CUERPO DE <br>
                <span style="font-weight: 200; font-style: italic;">FORMA NATURAL</span>
            </h1>
            <p class="hero-subtitle">
                Bienestar diario inspirado en la naturaleza. Productos artesanales, sostenibles y puros para una vida consciente.
            </p>
            <div class="flex gap-6">
                <a href="#" class="btn-primary">Ver Productos</a>
                <a href="#" class="btn-outline">Conocer Más</a>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="section-padding" style="background: white;">
        <div class="container">
            <div class="text-center mb-8">
                <h2 class="section-title">NUESTRAS CATEGORÍAS</h2>
                <div class="title-line"></div>
                <p class="mt-6" style="color: rgba(27, 48, 34, 0.6); max-width: 40rem; margin-left: auto; margin-right: auto;">
                    Descubre nuestra selección cuidadosamente curada de productos botánicos.
                </p>
            </div>

            <div class="category-grid">
                <!-- Infusiones -->
                <div class="category-card">
                    <img src="https://images.unsplash.com/photo-1563911191331-129ee759858b?auto=format&fit=crop&q=80&w=800" alt="Infusiones">
                    <div style="position: absolute; inset: 0; background: rgba(13, 26, 18, 0.3);"></div>
                    <div class="category-info">
                        <h3 style="font-size: 2rem; margin-bottom: 0.5rem;">INFUSIONES</h3>
                        <p style="color: rgba(255, 255, 255, 0.8); margin-bottom: 1.5rem;">Mezclas curativas y relajantes.</p>
                        <span style="font-weight: bold; text-transform: uppercase; letter-spacing: 0.1em; border-bottom: 1px solid white; padding-bottom: 2px;">
                            Explorar <i class="fas fa-arrow-right" style="font-size: 10px;"></i>
                        </span>
                    </div>
                </div>

                <!-- Aceites -->
                <div class="category-card">
                    <img src="https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?auto=format&fit=crop&q=80&w=800" alt="Aceites">
                    <div style="position: absolute; inset: 0; background: rgba(13, 26, 18, 0.3);"></div>
                    <div class="category-info">
                        <h3 style="font-size: 2rem; margin-bottom: 0.5rem;">ACEITES</h3>
                        <p style="color: rgba(255, 255, 255, 0.8); margin-bottom: 1.5rem;">Esencias puras para tu bienestar.</p>
                        <span style="font-weight: bold; text-transform: uppercase; letter-spacing: 0.1em; border-bottom: 1px solid white; padding-bottom: 2px;">
                            Explorar <i class="fas fa-arrow-right" style="font-size: 10px;"></i>
                        </span>
                    </div>
                </div>

                <!-- Cosmética -->
                <div class="category-card">
                    <img src="https://images.unsplash.com/photo-1556228720-195a672e8a03?auto=format&fit=crop&q=80&w=800" alt="Cosmética">
                    <div style="position: absolute; inset: 0; background: rgba(13, 26, 18, 0.3);"></div>
                    <div class="category-info">
                        <h3 style="font-size: 2rem; margin-bottom: 0.5rem;">COSMÉTICA</h3>
                        <p style="color: rgba(255, 255, 255, 0.8); margin-bottom: 1.5rem;">Cuidado natural para tu piel.</p>
                        <span style="font-weight: bold; text-transform: uppercase; letter-spacing: 0.1em; border-bottom: 1px solid white; padding-bottom: 2px;">
                            Explorar <i class="fas fa-arrow-right" style="font-size: 10px;"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="section-padding" style="background: var(--brand-cream);">
        <div class="container">
            <div style="display: flex; align-items: flex-end; justify-content: space-between; margin-bottom: 4rem;">
                <div>
                    <h2 class="section-title">PRODUCTOS DESTACADOS</h2>
                    <p style="color: rgba(27, 48, 34, 0.6);">Lo más querido por nuestra comunidad natural.</p>
                </div>
                <a href="#" style="font-weight: bold; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.1em; border-bottom: 1px solid var(--brand-green); padding-bottom: 2px;">
                    Ver todo el catálogo <i class="fas fa-arrow-right" style="margin-left: 0.5rem; font-size: 10px;"></i>
                </a>
            </div>

            <div class="product-grid">
                @php
                    $products = [
                        ['id' => 7, 'name' => 'Bruma de Rosas', 'price' => '22.00€', 'img' => asset('img/imgPrueba.png'), 'cat' => 'Nuevo'],
                        ['id' => 10, 'name' => 'Crema Facial Algas', 'price' => '28.00€', 'img' => asset('img/imgPrueba.png'), 'cat' => 'Premium'],
                        ['id' => 5, 'name' => 'Aceite de Menta', 'price' => '14.20€', 'img' => asset('img/imgPrueba.png'), 'cat' => 'Popular'],
                        ['id' => 2, 'name' => 'Aceite de Eucalipto', 'price' => '18.90€', 'img' => asset('img/imgPrueba.png'), 'cat' => 'Best Seller'],
                    ];
                @endphp

                @foreach($products as $product)
                <div class="product-card">
                    <a href="/producto/{{ $product['id'] }}">
                        <div class="product-img">
                            <img src="{{ $product['img'] }}" alt="{{ $product['name'] }}">
                            <div class="product-overlay" style="position: absolute; inset: 0; background: rgba(27, 48, 34, 0.05); opacity: 0; transition: opacity 0.3s; display: flex; align-items: center; justify-content: center;">
                                <span style="background: white; color: var(--brand-green); padding: 0.5rem 1rem; border-radius: 9999px; font-size: 0.75rem; font-weight: bold;">VER DETALLE</span>
                            </div>
                        </div>
                    </a>
                    <div class="product-details">
                        <span style="font-size: 10px; font-weight: bold; color: rgba(27, 48, 34, 0.4); text-transform: uppercase; letter-spacing: 0.2em; display: block; margin-bottom: 0.5rem;">{{ $product['cat'] }}</span>
                        <h4 style="font-weight: bold; font-size: 1.125rem; margin-bottom: 1rem;">{{ $product['name'] }}</h4>
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

    <!-- Values Section -->
    <section class="section-padding" style="background: white; border-top: 1px solid rgba(27, 48, 34, 0.05);">
        <div class="container">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 3rem; text-align: center;">
                <div>
                    <div style="width: 4rem; height: 4rem; background: rgba(27, 48, 34, 0.05); border-radius: 1rem; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin: 0 auto 1.5rem;">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h5 style="font-weight: bold; margin-bottom: 0.5rem;">100% NATURAL</h5>
                    <p style="color: rgba(27, 48, 34, 0.5); font-size: 0.875rem;">Ingredientes puros sin químicos dañinos.</p>
                </div>
                <div>
                    <div style="width: 4rem; height: 4rem; background: rgba(27, 48, 34, 0.05); border-radius: 1rem; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin: 0 auto 1.5rem;">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                    <h5 style="font-weight: bold; margin-bottom: 0.5rem;">SALUD Y CALMA</h5>
                    <p style="color: rgba(27, 48, 34, 0.5); font-size: 0.875rem;">Equilibrio para cuerpo y mente.</p>
                </div>
                <div>
                    <div style="width: 4rem; height: 4rem; background: rgba(27, 48, 34, 0.05); border-radius: 1rem; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin: 0 auto 1.5rem;">
                        <i class="fas fa-recycle"></i>
                    </div>
                    <h5 style="font-weight: bold; margin-bottom: 0.5rem;">SOSTENIBILIDAD</h5>
                    <p style="color: rgba(27, 48, 34, 0.5); font-size: 0.875rem;">Compromiso con el medio ambiente.</p>
                </div>
                <div>
                    <div style="width: 4rem; height: 4rem; background: rgba(27, 48, 34, 0.05); border-radius: 1rem; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin: 0 auto 1.5rem;">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <h5 style="font-weight: bold; margin-bottom: 0.5rem;">ECO-PACKAGING</h5>
                    <p style="color: rgba(27, 48, 34, 0.5); font-size: 0.875rem;">Envases reciclables y biodegradables.</p>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('js/jsHome.js') }}"></script>
@endpush