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
            <a href="{{ route('catalog.index') }}" class="boton botonPrincipal">VER PRODUCTOS</a>
        </div>
    </div>
</section>

<!-- Sección Categorías -->

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
                        <a href="{{ route('catalog.index') }}?categories[]={{ $cat['id'] }}" class="enlaceExplorar">EXPLORAR <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
        <button class="botonCarrusel botonCarruselDerecha" id="nextCatBtn" aria-label="Siguiente"><i class="fa-solid fa-chevron-right"></i></button>
    </div>
</section>


<!-- Sección Novedades (Productos más recientes) -->
<section id="novedades" class="seccionMasVendidos contenedorCentrado">
    <div class="cabeceraSeccion" style="display: flex; justify-content: space-between; align-items: flex-end; text-align: left;">
        <div>
            <h2>Recién llegados a nuestra tienda.</h2>
            <p style="color: rgba(27, 48, 34, 0.6);">Los últimos productos añadidos.</p>
        </div>
        <a href="{{ route('catalog.index') }}" class="boton botonContorno" style="width: auto;">VER TODO EL CATÁLOGO</a>
    </div>

    <div class="cuadriculaProductos product-grid">
        @foreach($latestProducts as $product)
        <div class="product-card">
            <a href="{{ route('catalog.show', $product->id) }}">
                <div class="product-img">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('img/imgPrueba.png') }}" alt="{{ $product->name }}" style="transition: transform 0.5s;">
                    <div class="product-overlay" style="position: absolute; inset: 0; background: rgba(27, 48, 34, 0.05); opacity: 0; transition: opacity 0.3s; display: flex; align-items: center; justify-content: center;">
                        <span style="background: white; color: var(--brand-green); padding: 0.5rem 1rem; border-radius: 9999px; font-size: 0.75rem; font-weight: bold;">VER DETALLE</span>
                    </div>
                </div>
            </a>
            <div class="product-details">
                <span style="font-size: 10px; font-weight: bold; color: rgba(27, 48, 34, 0.4); text-transform: uppercase; letter-spacing: 0.2em; display: block; margin-bottom: 0.5rem;">
                    {{ $product->categories->first()?->name ?? 'Nuevo' }}
                </span>
                <h4 style="font-weight: bold; font-size: 1.125rem; margin-bottom: 1rem;">
                    <a href="{{ route('catalog.show', $product->id) }}">{{ $product->name }}</a>
                </h4>
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <span style="font-size: 1.25rem; font-weight: 300;">{{ number_format($product->price, 2, ',', '.') }}€</span>
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