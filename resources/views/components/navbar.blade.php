<nav class="barraNavegacion">
    <div class="navegacionIzquierda">
        <a href="/" class="marca" style="text-decoration: none;">
            <i class="fa-solid fa-leaf iconoMarca"></i>
            LA BOTICA NATURAL
        </a>
        <div class="enlacesNavegacion">
            <a href="/catalogo">CATÁLOGO</a>
            <a href="/#categorias">CATEGORÍAS</a>
            <a href="/#novedades">NOVEDADES</a>
            <a href="/#sobre-nosotros">SOBRE NOSOTROS</a>
        </div>
    </div>
    
    <div class="navegacionDerecha">
        <div class="barraBusqueda">
            <i class="fa-solid fa-magnifying-glass iconoBusqueda"></i>
            <input type="text" placeholder="Buscar...">
        </div>
        
        <div class="menuUsuarioContenedor">
            <button class="botonIcono" id="botonUsuario">
                <i class="fa-regular fa-user"></i>
            </button>
            <div class="menuUsuarioDesplegable" id="menuUsuario">
                @if(session('logged_in'))
                    <a href="/perfil">Mi Perfil</a>
                    <div class="divisorMenu" style="height: 1px; background: #eee; margin: 0.5rem 0;"></div>
                    <a href="/logout" style="color: #ff4d4d;">Cerrar Sesión</a>
                @else
                    <a href="/login">Iniciar Sesión</a>
                    <a href="/register">Registrarse</a>
                @endif
            </div>
        </div>
        
        <a href="/carrito" class="enlaceIcono">
            <i class="fa-solid fa-cart-shopping"></i>
        </a>
    </div>
</nav>
