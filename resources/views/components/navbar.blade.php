<nav class="barraNavegacion">
    <div class="navegacionIzquierda">
        <a href="{{ url('/') }}" class="marca marca-premium">
            <img src="{{ asset('img/logo.jpg') }}" alt="Logo La Botica Natural" class="iconoMarca">
            <span class="nombreMarca">{{ \Illuminate\Support\Facades\Cache::get('shop_name', 'La Botica Natural') }}</span>
        </a>
        <div class="enlacesNavegacion">
            <a href="{{ route('catalog.index') }}">Catálogo</a>
            <a href="{{ url('/#categorias') }}">Categorías</a>
            <a href="{{ url('/#novedades') }}">Novedades</a>
            <a href="{{ url('/#sobre-nosotros') }}">Sobre nosotros</a>
        </div>
    </div>

    <div class="navegacionDerecha">
        <form action="{{ route('catalog.index') }}" method="GET" class="barraBusqueda">
            <i class="fa-solid fa-magnifying-glass iconoBusqueda" onclick="this.closest('form').submit();" role="button" tabindex="0" aria-label="Buscar"></i>
            <input type="text" name="search" placeholder="Buscar..." value="{{ request('search') }}" aria-label="Buscar productos">
        </form>

        <div class="nav-acciones-iconos">
            <div class="menuUsuarioContenedor">
                <button
                    type="button"
                    class="nav-icono-btn nav-icono-perfil {{ session('logged_in') ? 'nav-icono-perfil--activo' : '' }}"
                    id="botonUsuario"
                    aria-expanded="false"
                    aria-haspopup="true"
                    aria-controls="menuUsuario"
                    aria-label="{{ session('logged_in') ? 'Menú de mi cuenta' : 'Iniciar sesión' }}"
                >
                    <i class="fa-solid fa-user"></i>
                </button>
                <div class="menuUsuarioDesplegable" id="menuUsuario" role="menu">
                    @if(session('logged_in'))
                        <p class="menuUsuarioTitulo" role="presentation">Mi cuenta</p>
                        <a href="{{ route('profile') }}" role="menuitem" class="menuUsuarioEnlace">
                            <i class="fa-solid fa-id-card"></i>
                            <span>Mi perfil</span>
                        </a>
                        <div class="divisorMenu" role="separator"></div>
                        <a href="{{ route('logout') }}" role="menuitem" class="menuUsuarioEnlace menuUsuarioEnlace--salir">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span>Cerrar sesión</span>
                        </a>
                    @else
                        <p class="menuUsuarioTitulo" role="presentation">Acceso</p>
                        <a href="{{ route('login') }}" role="menuitem" class="menuUsuarioEnlace menuUsuarioEnlace--principal">
                            <i class="fa-solid fa-right-to-bracket"></i>
                            <span>Iniciar sesión</span>
                        </a>
                    @endif
                </div>
            </div>

            <a href="{{ route('cart.index') }}" class="nav-icono-btn nav-icono-carrito" aria-label="Ver carrito">
                <i class="fa-solid fa-cart-shopping"></i>
                @php
                    $cartCount = 0;
                    if (session('cart')) {
                        foreach (session('cart') as $item) {
                            $cartCount += $item['qty'];
                        }
                    }
                @endphp
                @if($cartCount > 0)
                    <span class="nav-badge-carrito">{{ $cartCount > 9 ? '9+' : $cartCount }}</span>
                @endif
            </a>
            <!-- Hamburger Button for Mobile -->
            <button type="button" class="nav-icono-btn btn-hamburger" id="btnHamburger" aria-label="Abrir menú">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>
    </div>
</nav>

<!-- Mobile Drawer Menu Overlay -->
<div class="menu-movil-overlay" id="menuMovilOverlay"></div>

<!-- Mobile Drawer Menu Container -->
<div class="menu-movil-drawer" id="menuMovilDrawer">
    <div class="menu-movil-header">
        <a href="{{ url('/') }}" class="marca marca-premium">
            <img src="{{ asset('img/logo.jpg') }}" alt="Logo La Botica Natural" class="iconoMarca">
            <span class="nombreMarca">La Botica Natural</span>
        </a>
        <button type="button" class="btn-cerrar-drawer" id="btnCerrarDrawer" aria-label="Cerrar menú">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    
    <div class="menu-movil-contenido">
        <!-- Search bar for mobile drawer -->
        <form action="{{ route('catalog.index') }}" method="GET" class="barraBusqueda-movil">
            <input type="text" name="search" placeholder="Buscar productos..." value="{{ request('search') }}" aria-label="Buscar productos">
            <button type="submit" aria-label="Buscar"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
        
        <!-- Mobile Links -->
        <div class="menu-movil-enlaces">
            <a href="{{ route('catalog.index') }}"><i class="fa-solid fa-store"></i> Catálogo</a>
            <a href="{{ url('/#categorias') }}"><i class="fa-solid fa-tags"></i> Categorías</a>
            <a href="{{ url('/#novedades') }}"><i class="fa-solid fa-star"></i> Novedades</a>
            <a href="{{ url('/#sobre-nosotros') }}"><i class="fa-solid fa-circle-info"></i> Sobre nosotros</a>
        </div>

        <div class="divisorMenu" style="margin: 2rem 0 1rem; opacity: 0.15;"></div>

        <!-- Mobile User Account Actions -->
        <div class="menu-movil-usuario">
            @if(session('logged_in'))
                <p class="menuUsuarioTitulo">Mi Cuenta</p>
                <a href="{{ route('profile') }}" class="menu-movil-enlace-user">
                    <i class="fa-solid fa-id-card"></i> <span>Mi perfil</span>
                </a>
                <a href="{{ route('logout') }}" class="menu-movil-enlace-user menu-movil-enlace-user--salir">
                    <i class="fa-solid fa-right-from-bracket"></i> <span>Cerrar sesión</span>
                </a>
            @else
                <p class="menuUsuarioTitulo">Acceso</p>
                <a href="{{ route('login') }}" class="btn-primary" style="display: flex; justify-content: center; width: 100%; text-decoration: none; border-radius: 9999px; font-weight: 600; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.05em; padding: 0.85rem 1.5rem; background: var(--color-principal); color: white; text-align: center;">
                    Iniciar sesión
                </a>
            @endif
        </div>
    </div>
</div>
