@extends('landingPage')

@push('style')
    <link rel="stylesheet" href="{{ asset('css/styleHome.css') }}?v={{ time() }}">
@endpush

@section('main_content')

<!-- Sección Hero Principal -->
<section class="seccionHero">
    <div class="capaOscura"></div>
    <div class="contenidoHero">
        <div class="hero-brand-stamp-container">
            <img src="{{ asset('img/logo.jpg') }}" alt="Sello La Botica Natural" class="hero-brand-stamp">
        </div>
        <span class="badge-bienvenida">BIENVENIDO A NUESTRO HERBOLARIO</span>
        <h1 class="tituloHero">Bienestar diario inspirado en la <span class="resaltado-organico">naturaleza</span>.</h1>
        <p class="subtituloHero">Productos artesanales, sostenibles y puros para cultivar una vida consciente y saludable.</p>
        <div class="botonesHero">
            <a href="{{ route('catalog.index') }}" class="boton botonPrincipal">
                <span>VER PRODUCTOS</span>
                <i class="fa-solid fa-arrow-right-long"></i>
            </a>
        </div>
    </div>
    
    <div class="scroll-indicador">
        <span class="scroll-texto">Deslizar para explorar</span>
        <div class="scroll-linea"></div>
    </div>
</section>

<!-- Sección Categorías -->
<section id="categorias" class="seccionCategorias">
    <div class="contenedorCentrado">
        <div class="cabeceraSeccion">
            <span class="subtituloSeccion">NUESTRAS FAMILIAS BOTÁNICAS</span>
            <h2>Colecciones Seleccionadas</h2>
            <div class="decoracionCabecera"><span class="lineaCabecera"></span><i class="fa-solid fa-seedling"></i><span class="lineaCabecera"></span></div>
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
                            <a href="{{ route('catalog.index') }}?categories[]={{ $cat['id'] }}" class="enlaceExplorar">
                                <span class="enlaceTexto">EXPLORAR</span>
                                <i class="fa-solid fa-arrow-right-long iconoFlecha"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            
            <button class="botonCarrusel botonCarruselDerecha" id="nextCatBtn" aria-label="Siguiente"><i class="fa-solid fa-chevron-right"></i></button>
        </div>
    </div>
</section>

<!-- Sección Novedades (Productos más recientes) -->
<section id="novedades" class="seccionMasVendidos">
    <div class="contenedorCentrado">
        <div class="cabeceraSeccionNovedades">
            <div class="cabeceraTexto">
                <span class="subtituloSeccion">RECIÉN LLEGADOS A NUESTRA TIENDA</span>
                <h2>Los Últimos Productos Añadidos</h2>
            </div>
            <div class="botonContenedorCat">
                <a href="{{ route('catalog.index') }}" class="boton botonContorno">VER TODO EL CATÁLOGO</a>
            </div>
        </div>

        <div class="cuadriculaProductos product-grid">
            @foreach($latestProducts as $product)
            <div class="product-card">
                <a href="{{ route('catalog.show', $product->id) }}">
                    <div class="product-img">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy" decoding="async">
                        <div class="product-overlay">
                            <span class="badge-detalle">VER DETALLE</span>
                        </div>
                    </div>
                </a>
                <div class="product-details">
                    <span class="producto-categoria">
                        {{ $product->categories->first()?->name ?? 'Nuevo' }}
                    </span>
                    <h4 class="producto-titulo">
                        <a href="{{ route('catalog.show', $product->id) }}">{{ $product->name }}</a>
                    </h4>
                    <div class="producto-pie">
                        <span class="producto-precio">{{ number_format($product->price, 2, ',', '.') }}€</span>
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" style="margin: 0; padding: 0; border: none; background: transparent; display: inline-flex; align-items: center;">
                            @csrf
                            <input type="hidden" name="qty" value="1">
                            <button type="submit" class="btn-anadir">
                                <span>Añadir</span>
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Sección Características / Valores -->
<section id="sobre-nosotros" class="seccionCaracteristicas">
    <div class="contenedorCentrado">
        
        <!-- Bloque de Historia y Sello de Calidad -->
        <div class="historia-wrapper">
            <div class="historia-sello-container">
                <div class="sello-decoracion-anillos"></div>
                <img src="{{ asset('img/logo.jpg') }}" alt="Sello de Calidad La Botica Natural" class="sello-historia-imagen" loading="lazy" decoding="async">
            </div>
            <div class="historia-contenido">
                <span class="subtituloSeccion">DESDE 1994</span>
                <h2 class="historia-titulo">
                    Un compromiso inquebrantable con tu <span class="resaltado-organico">bienestar puro</span>.
                </h2>
                <p class="historia-parrafo">
                    Fundada hace más de tres décadas, La Botica Natural nació con un propósito claro: reconectar a las personas con el poder curativo de las plantas y los extractos botánicos más puros. Cada fórmula es elaborada artesanalmente por farmacéuticos expertos, respetando los ciclos de la tierra y los estándares éticos de sostenibilidad.
                </p>
                <p class="historia-parrafo">
                    Nuestro sello es garantía de trazabilidad ecológica, formulación científica de vanguardia y amor por lo natural. Llevamos más de 30 años cultivando la salud holística y el bienestar consciente para toda nuestra comunidad.
                </p>
            </div>
        </div>

        <div class="cuadriculaCaracteristicas">
            <div class="itemCaracteristica">
                <div class="iconoContenedor">
                    <svg class="svgCaracteristica" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M12 3C8.5 6.5 6.5 10 7.5 13.5C8.5 17 12 21 12 21C12 21 15.5 17 16.5 13.5C17.5 10 15.5 6.5 12 3Z" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 3V21" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 9C10.5 10.5 9 11.5 7.5 12" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 13C13.5 14.5 15 15.5 16.5 16" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h3>100% NATURAL</h3>
                <p>Ingredientes puros sin químicos dañinos ni aditivos sintéticos de ningún tipo.</p>
            </div>
            <div class="itemCaracteristica">
                <div class="iconoContenedor">
                    <svg class="svgCaracteristica" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M12 22C12 22 17 18 19 14.5C21 11 19.5 8 18 7C16.5 6 14.5 7.5 12 10.5C9.5 7.5 7.5 6 6 7C4.5 8 3 11 5 14.5C7 18 12 22 12 22Z" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 10.5V22" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 15C13 15.5 14.5 15.5 15.5 15" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 15C11 15.5 9.5 15.5 8.5 15" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h3>SALUD Y CALMA</h3>
                <p>Diseñados meticulosamente para equilibrar tu cuerpo y mente cada día.</p>
            </div>
            <div class="itemCaracteristica">
                <div class="iconoContenedor">
                    <svg class="svgCaracteristica" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="12" r="9" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M3.6 9H20.4" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M3.6 15H20.4" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 3C14.5 5.5 15.5 8.5 15.5 12C15.5 15.5 14.5 18.5 12 21C9.5 18.5 8.5 15.5 8.5 12C8.5 8.5 9.5 5.5 12 3Z" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h3>SOSTENIBILIDAD</h3>
                <p>Un compromiso real y verificable con el medio ambiente y el comercio justo.</p>
            </div>
            <div class="itemCaracteristica">
                <div class="iconoContenedor">
                    <svg class="svgCaracteristica" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M21 7.5L12 3L3 7.5L12 12L21 7.5Z" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M3 7.5V16.5L12 21V12L3 7.5Z" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M21 7.5V16.5L12 21V12L21 7.5Z" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M7.5 9.75L16.5 14.25" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h3>ECO-PACKAGING</h3>
                <p>Envases 100% reciclables y biodegradables para reducir al mínimo nuestra huella.</p>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
    <script src="{{ asset('js/jsHome.js') }}"></script>
@endpush