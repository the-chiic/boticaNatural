<nav class="barraNavegacion">
    <div class="navegacionIzquierda">
        <a href="{{ url('/') }}" class="marca" style="text-decoration: none;">
            <i class="fa-solid fa-leaf iconoMarca"></i>
            LA BOTICA NATURAL
        </a>
        <div class="enlacesNavegacion">
            <a href="{{ url('catalogo') }}">CATÁLOGO</a>
            <a href="{{ url('catalogo') }}">INFUSIONES</a>
            <a href="{{ url('catalogo') }}">COSMÉTICA</a>
            <a href="{{ url('catalogo') }}">ACEITES</a>
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
                    <a href="{{ url('perfil') }}">Mi Perfil</a>
                    <div class="divisorMenu" style="height: 1px; background: #eee; margin: 0.5rem 0;"></div>
                    <a href="{{ url('cerrar-sesion') }}" style="color: #ff4d4d;">Cerrar Sesión</a>
                @else
                    <a href="{{ url('iniciar-sesion') }}">Iniciar Sesión</a>
                    <a href="{{ url('registrarse') }}">Registrarse</a>
                @endif
            </div>
        </div>
        
        <a href="{{ url('carrito') }}" class="enlaceIcono">
            <i class="fa-solid fa-cart-shopping"></i>
        </a>
    </div>
</nav>
