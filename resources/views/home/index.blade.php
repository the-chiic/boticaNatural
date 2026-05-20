@extends('landingPage')

@push('style')
    <link rel="stylesheet" href="{{ asset('css/styleHome.css') }}?v={{ time() }}">
@endpush

@section('main_content')

<!-- Sección Hero Principal -->
<section class="seccionHero">
    <div class="capaOscura"></div>
    <div class="contenidoHero">
        <h1 class="tituloHero">Bienestar diario inspirado en la naturaleza.</h1>
        <p class="subtituloHero">Productos artesanales, sostenibles y puros para una vida consciente.</p>
        <div class="botonesHero">
            <a href="/catalogo" class="boton botonPrincipal">VER PRODUCTOS</a>
        </div>
    </div>
</section>

<!-- Sección Categorías -->
@php
    $resolvedCategories = [];
    foreach ($categories as $category) {
        $nameLower = mb_strtolower($category->name);
        $bgUrl = 'https://images.unsplash.com/photo-1465146344425-f00d5f5c8f07?q=80&w=800&auto=format&fit=crop'; // default
        
        if (str_contains($nameLower, 'infusion') || str_contains($nameLower, 'té') || str_contains($nameLower, 'te')) {
            $bgUrl = 'https://images.unsplash.com/photo-1576092762791-dd9e2220d960?q=80&w=800&auto=format&fit=crop';
        } elseif (str_contains($nameLower, 'aceite')) {
            $bgUrl = 'https://images.unsplash.com/photo-1608248543803-ba4f8c70ae0b?q=80&w=800&auto=format&fit=crop';
        } elseif (str_contains($nameLower, 'cosmet') || str_contains($nameLower, 'cosmét')) {
            $bgUrl = 'https://images.unsplash.com/photo-1556228573-7303e8707198?q=80&w=800&auto=format&fit=crop';
        } elseif (str_contains($nameLower, 'medic')) {
            $bgUrl = 'https://images.unsplash.com/photo-1471864190281-a93a3070b6de?q=80&w=800&auto=format&fit=crop';
        } elseif (str_contains($nameLower, 'herbol') || str_contains($nameLower, 'plant') || str_contains($nameLower, 'natural')) {
            $bgUrl = 'https://images.unsplash.com/photo-1515694346937-94d85e41e6f0?q=80&w=800&auto=format&fit=crop';
        }
        
        $resolvedCategories[] = [
            'id' => $category->id,
            'name' => $category->name,
            'description' => $category->description ?? 'Descubre nuestra selección de ' . $category->name,
            'bgUrl' => $bgUrl
        ];
    }

    // Ensure we have at least 6 categories for seamless infinite scrolling
    $displayCategories = $resolvedCategories;
    if (count($resolvedCategories) > 0 && count($resolvedCategories) < 6) {
        $displayCategories = array_merge($resolvedCategories, $resolvedCategories);
        if (count($displayCategories) < 6) {
            $displayCategories = array_merge($displayCategories, $resolvedCategories);
        }
    }
@endphp

<section id="categorias" class="seccionCategorias contenedorCentrado">
    <div class="cabeceraSeccion">
        <h2>Descubre nuestra selección cuidadosamente curada de productos botánicos.</h2>
    </div>
    
    <div class="carruselWrapper">
        <button class="botonCarrusel botonCarruselIzquierda" id="prevCatBtn" aria-label="Anterior"><i class="fa-solid fa-chevron-left"></i></button>
        
        <div class="carruselCategorias" id="carruselCategorias">
            <div class="cuadriculaCategorias carruselTrack" id="carruselTrack">
                @foreach($displayCategories as $cat)
                <div class="tarjetaCategoria">
                    <div class="imagenCategoria" style="background-image: url('{{ $cat['bgUrl'] }}');"></div>
                    <div class="contenidoTarjetaCategoria">
                        <h3>{{ $cat['name'] }}</h3>
                        <p>{{ $cat['description'] }}</p>
                        <a href="/catalogo?categories[]={{ $cat['id'] }}" class="enlaceExplorar">EXPLORAR <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
        <button class="botonCarrusel botonCarruselDerecha" id="nextCatBtn" aria-label="Siguiente"><i class="fa-solid fa-chevron-right"></i></button>
    </div>
</section>

<!-- Sección Best Sellers -->
<section id="novedades" class="seccionMasVendidos contenedorCentrado">
    <div class="cabeceraSeccion" style="display: flex; justify-content: space-between; align-items: flex-end; text-align: left;">
        <div>
            <h2>Lo más querido por nuestra comunidad.</h2>
            <p style="color: rgba(27, 48, 34, 0.6);">Selección de nuestros favoritos.</p>
        </div>
        <a href="/catalogo" class="boton botonContorno" style="width: auto;">VER TODO EL CATÁLOGO</a>
    </div>

    <div class="cuadriculaProductos product-grid">
        @php
            $products = [
                ['id' => 2, 'name' => 'Aceite de Eucalipto', 'price' => '18.90€', 'img' => asset('img/imgPrueba.png'), 'cat' => 'Best Seller'],
                ['id' => 7, 'name' => 'Bruma de Rosas', 'price' => '22.00€', 'img' => asset('img/imgPrueba.png'), 'cat' => 'Nuevo'],
                ['id' => 10, 'name' => 'Crema Facial Algas', 'price' => '28.00€', 'img' => asset('img/imgPrueba.png'), 'cat' => 'Premium'],
                ['id' => 5, 'name' => 'Aceite de Menta', 'price' => '14.20€', 'img' => asset('img/imgPrueba.png'), 'cat' => 'Popular'],
            ];
        @endphp

        @foreach($products as $product)
        <div class="product-card">
            <a href="/producto/{{ $product['id'] }}">
                <div class="product-img">
                    <img src="{{ $product['img'] }}" alt="{{ $product['name'] }}">
                    <div class="product-overlay">
                        <span>VER DETALLE</span>
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
</section>

<!-- Sección Características / Valores -->
<section id="sobre-nosotros" class="seccionCaracteristicas">
    <div class="contenedorCentrado cuadriculaCaracteristicas">
        <div class="itemCaracteristica">
            <i class="fa-solid fa-leaf iconoCaracteristica"></i>
            <h3>100% NATURAL</h3>
            <p>Ingredientes puros sin químicos dañinos ni aditivos sintéticos.</p>
        </div>
        <div class="itemCaracteristica">
            <i class="fa-solid fa-spa iconoCaracteristica"></i>
            <h3>SALUD Y CALMA</h3>
            <p>Diseñados para equilibrar tu cuerpo y mente cada día.</p>
        </div>
        <div class="itemCaracteristica">
            <i class="fa-solid fa-earth-europe iconoCaracteristica"></i>
            <h3>SOSTENIBILIDAD</h3>
            <p>Compromiso real con el medio ambiente y comercio justo.</p>
        </div>
        <div class="itemCaracteristica">
            <i class="fa-solid fa-box-open iconoCaracteristica"></i>
            <h3>ECO-PACKAGING</h3>
            <p>Envases reciclables y biodegradables para reducir huella.</p>
        </div>
    </div>
</section>

@endsection

@push('scripts')
    <script src="{{ asset('js/jsHome.js') }}"></script>
@endpush