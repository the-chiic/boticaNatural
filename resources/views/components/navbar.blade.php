<nav class="barraNavegacion">
    <div class="navegacionIzquierda">
        <a href="{{ url('/') }}" class="marca">
            <i class="fa-solid fa-leaf iconoMarca"></i>
            {{ \Illuminate\Support\Facades\Cache::get('shop_name', 'LA BOTICA NATURAL') }}
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
        </div>
    </div>
</nav>
