<nav class="barraNavegacion">
    <div class="navegacionIzquierda">
        <a href="{{ url('/') }}" class="marca" style="text-decoration: none;">
            <i class="fa-solid fa-leaf iconoMarca"></i>
            {{ \Illuminate\Support\Facades\Cache::get('shop_name', 'LA BOTICA NATURAL') }}
        </a>
        <div class="enlacesNavegacion">
            <a href="{{ route('catalog.index') }}">CATÁLOGO</a>
            <a href="{{ url('/#categorias') }}">CATEGORÍAS</a>
            <a href="{{ url('/#novedades') }}">NOVEDADES</a>
            <a href="{{ url('/#sobre-nosotros') }}">SOBRE NOSOTROS</a>
        </div>
    </div>
    
    <div class="navegacionDerecha">
        <form action="{{ route('catalog.index') }}" method="GET" class="barraBusqueda">
            <i class="fa-solid fa-magnifying-glass iconoBusqueda" style="cursor: pointer;" onclick="this.closest('form').submit();"></i>
            <input type="text" name="search" placeholder="Buscar..." value="{{ request('search') }}">
        </form>
        
        <div class="menuUsuarioContenedor">
            <button class="botonIcono" id="botonUsuario">
                <i class="fa-regular fa-user"></i>
            </button>
            <div class="menuUsuarioDesplegable" id="menuUsuario">
                @if(session('logged_in'))
                    <a href="{{ url('/perfil') }}">Mi Perfil</a>
                    <div class="divisorMenu" style="height: 1px; background: #eee; margin: 0.5rem 0;"></div>
                    <a href="{{ route('logout') }}" style="color: #ff4d4d;">Cerrar Sesión</a>
                @else
                    <a href="{{ route('login') }}">Iniciar Sesión</a>
                    <a href="{{ route('register') }}">Registrarse</a>
                @endif
            </div>
        </div>
        
        <a href="{{ url('/carrito') }}" class="enlaceIcono" style="position: relative;">
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
                <span class="badge-carrito" style="position: absolute; top: -6px; right: -8px; background: var(--brand-accent); color: white; border-radius: 50%; width: 17px; height: 17px; font-size: 10px; display: flex; align-items: center; justify-content: center; font-weight: bold; font-family: 'Instrument Sans', sans-serif;">
                    {{ $cartCount }}
                </span>
            @endif
        </a>
    </div>
</nav>
