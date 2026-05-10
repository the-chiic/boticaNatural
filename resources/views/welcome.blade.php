@extends('layouts.app')

@section('content')

<!-- Sección Hero Principal -->
<section class="seccion-hero">
    <div class="capa-oscura"></div>
    <div class="contenido-hero">
        <h1 class="titulo-hero">Bienestar diario inspirado en la naturaleza.</h1>
        <p class="subtitulo-hero">Productos artesanales, sostenibles y puros para una vida consciente.</p>
        <div class="botones-hero">
            <a href="#" class="boton boton-principal">VER PRODUCTOS</a>
            <a href="#" class="boton boton-contorno boton-blanco">CONOCER MÁS</a>
        </div>
    </div>
</section>

<!-- Sección Categorías -->
<section class="seccion-categorias contenedor-centrado">
    <div class="cabecera-seccion">
        <h2>Descubre nuestra selección cuidadosamente curada de productos botánicos.</h2>
    </div>
    
    <div class="cuadricula-categorias">
        <div class="tarjeta-categoria">
            <div class="imagen-categoria infusiones-bg"></div>
            <div class="contenido-tarjeta-categoria">
                <h3>Infusiones</h3>
                <p>Mezclas curativas y relajantes.</p>
                <a href="#" class="enlace-explorar">EXPLORAR <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </div>
        <div class="tarjeta-categoria">
            <div class="imagen-categoria aceites-bg"></div>
            <div class="contenido-tarjeta-categoria">
                <h3>Aceites</h3>
                <p>Esencias puras para tu bienestar.</p>
                <a href="#" class="enlace-explorar">EXPLORAR <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </div>
        <div class="tarjeta-categoria">
            <div class="imagen-categoria cosmetica-bg"></div>
            <div class="contenido-tarjeta-categoria">
                <h3>Cosmética</h3>
                <p>Cuidado natural para tu piel.</p>
                <a href="#" class="enlace-explorar">EXPLORAR <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- Sección Best Sellers -->
<section class="seccion-mas-vendidos contenedor-centrado">
    <div class="cabecera-seccion flex-espacio">
        <h2>Lo más querido por nuestra comunidad natural.</h2>
        <a href="#" class="boton boton-contorno">VER TODO EL CATÁLOGO</a>
    </div>

    <div class="cuadricula-productos">
        <!-- Producto 1 -->
        <div class="tarjeta-producto">
            <div class="imagen-producto">
                <span class="etiqueta-destacado">BEST SELLER</span>
            </div>
            <div class="info-producto">
                <h4>Infusión de Lavanda</h4>
                <p class="precio-producto">12.50€</p>
            </div>
        </div>
        
        <!-- Producto 2 -->
        <div class="tarjeta-producto">
            <div class="imagen-producto">
                <span class="etiqueta-destacado">BEST SELLER</span>
            </div>
            <div class="info-producto">
                <h4>Aceite de Eucalipto</h4>
                <p class="precio-producto">18.90€</p>
            </div>
        </div>

        <!-- Producto 3 -->
        <div class="tarjeta-producto">
            <div class="imagen-producto">
                <span class="etiqueta-destacado">BEST SELLER</span>
            </div>
            <div class="info-producto">
                <h4>Jabón de Caléndula</h4>
                <p class="precio-producto">8.00€</p>
            </div>
        </div>

        <!-- Producto 4 -->
        <div class="tarjeta-producto">
            <div class="imagen-producto">
                <span class="etiqueta-destacado">BEST SELLER</span>
            </div>
            <div class="info-producto">
                <h4>Bálsamo de Árnica</h4>
                <p class="precio-producto">15.75€</p>
            </div>
        </div>
    </div>
</section>

<!-- Sección Características / Valores -->
<section class="seccion-caracteristicas">
    <div class="contenedor-centrado cuadricula-caracteristicas">
        <div class="item-caracteristica">
            <i class="fa-solid fa-leaf icono-caracteristica"></i>
            <h3>100% NATURAL</h3>
            <p>Ingredientes puros sin químicos dañinos ni aditivos sintéticos.</p>
        </div>
        <div class="item-caracteristica">
            <i class="fa-solid fa-spa icono-caracteristica"></i>
            <h3>SALUD Y CALMA</h3>
            <p>Diseñados para equilibrar tu cuerpo y mente cada día.</p>
        </div>
        <div class="item-caracteristica">
            <i class="fa-solid fa-earth-europe icono-caracteristica"></i>
            <h3>SOSTENIBILIDAD</h3>
            <p>Compromiso real con el medio ambiente y comercio justo.</p>
        </div>
        <div class="item-caracteristica">
            <i class="fa-solid fa-box-open icono-caracteristica"></i>
            <h3>ECO-PACKAGING</h3>
            <p>Envases reciclables y biodegradables para reducir huella.</p>
        </div>
    </div>
</section>

@endsection
