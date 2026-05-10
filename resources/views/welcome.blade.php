@extends('layouts.app')

@section('content')

<!-- Sección Hero Principal -->
<section class="seccionHero">
    <div class="capaOscura"></div>
    <div class="contenidoHero">
        <h1 class="tituloHero">Bienestar diario inspirado en la naturaleza.</h1>
        <p class="subtituloHero">Productos artesanales, sostenibles y puros para una vida consciente.</p>
        <div class="botonesHero">
            <a href="#" class="boton botonPrincipal">VER PRODUCTOS</a>
            <a href="#" class="boton botonContorno botonBlanco">CONOCER MÁS</a>
        </div>
    </div>
</section>

<!-- Sección Categorías -->
<section class="seccionCategorias contenedorCentrado">
    <div class="cabeceraSeccion">
        <h2>Descubre nuestra selección cuidadosamente curada de productos botánicos.</h2>
    </div>
    
    <div class="cuadriculaCategorias">
        <div class="tarjetaCategoria">
            <div class="imagenCategoria infusionesBg"></div>
            <div class="contenidoTarjetaCategoria">
                <h3>Infusiones</h3>
                <p>Mezclas curativas y relajantes.</p>
                <a href="#" class="enlaceExplorar">EXPLORAR <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </div>
        <div class="tarjetaCategoria">
            <div class="imagenCategoria aceitesBg"></div>
            <div class="contenidoTarjetaCategoria">
                <h3>Aceites</h3>
                <p>Esencias puras para tu bienestar.</p>
                <a href="#" class="enlaceExplorar">EXPLORAR <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </div>
        <div class="tarjetaCategoria">
            <div class="imagenCategoria cosmeticaBg"></div>
            <div class="contenidoTarjetaCategoria">
                <h3>Cosmética</h3>
                <p>Cuidado natural para tu piel.</p>
                <a href="#" class="enlaceExplorar">EXPLORAR <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- Sección Best Sellers -->
<section class="seccionMasVendidos contenedorCentrado">
    <div class="cabeceraSeccion flexEspacio">
        <h2>Lo más querido por nuestra comunidad natural.</h2>
        <a href="#" class="boton botonContorno">VER TODO EL CATÁLOGO</a>
    </div>

    <div class="cuadriculaProductos">
        <!-- Producto 1 -->
        <div class="tarjetaProducto">
            <div class="imagenProducto">
                <span class="etiquetaDestacado">BEST SELLER</span>
            </div>
            <div class="infoProducto">
                <h4>Infusión de Lavanda</h4>
                <p class="precioProducto">12.50€</p>
            </div>
        </div>
        
        <!-- Producto 2 -->
        <div class="tarjetaProducto">
            <div class="imagenProducto">
                <span class="etiquetaDestacado">BEST SELLER</span>
            </div>
            <div class="infoProducto">
                <h4>Aceite de Eucalipto</h4>
                <p class="precioProducto">18.90€</p>
            </div>
        </div>

        <!-- Producto 3 -->
        <div class="tarjetaProducto">
            <div class="imagenProducto">
                <span class="etiquetaDestacado">BEST SELLER</span>
            </div>
            <div class="infoProducto">
                <h4>Jabón de Caléndula</h4>
                <p class="precioProducto">8.00€</p>
            </div>
        </div>

        <!-- Producto 4 -->
        <div class="tarjetaProducto">
            <div class="imagenProducto">
                <span class="etiquetaDestacado">BEST SELLER</span>
            </div>
            <div class="infoProducto">
                <h4>Bálsamo de Árnica</h4>
                <p class="precioProducto">15.75€</p>
            </div>
        </div>
    </div>
</section>

<!-- Sección Características / Valores -->
<section class="seccionCaracteristicas">
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
