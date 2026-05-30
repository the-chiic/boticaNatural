<aside class="sidebar">
    <div class="sidebar-header">
        <img src="{{ asset('img/logo.jpg') }}" alt="Sello La Botica Natural" class="sidebar-logo-img" style="width: 64px; height: 64px; border-radius: 50%; object-fit: cover; border: 2px solid rgba(255,255,255,0.25); box-shadow: 0 4px 20px rgba(0,0,0,0.2); margin: 0 auto 12px; display: block; transition: transform 0.6s cubic-bezier(0.16,1,0.3,1);">
        <h2>LA BOTICA NATURAL</h2>
        <p>NATURAL • PURO • CONSCIENTE</p>
    </div>
    <ul class="menu">
        <a href="{{ route('admin.dashboard') }}">
            <li class="{{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-table-cells-large"></i> Dashboard
            </li>
        </a>
        <a href="{{ route('admin.productos') }}">
            <li class="{{ Request::routeIs('admin.productos') ? 'active' : '' }}">
                <i class="fa-solid fa-seedling"></i> Productos
            </li>
        </a>
        <a href="{{ route('admin.categorias') }}">
            <li class="{{ Request::routeIs('admin.categorias') ? 'active' : '' }}">
                <i class="fa-solid fa-tags"></i> Categorías
            </li>
        </a>
        <a href="{{ route('admin.pedidos') }}">
            <li class="{{ Request::routeIs('admin.pedidos') ? 'active' : '' }}">
                <i class="fa-solid fa-bag-shopping"></i> Pedidos
            </li>
        </a>
        <a href="{{ route('admin.clientes') }}">
            <li class="{{ Request::routeIs('admin.clientes') ? 'active' : '' }}">
                <i class="fa-solid fa-users"></i> Clientes
            </li>
        </a>
        <a href="{{ route('admin.promociones') }}">
            <li class="{{ Request::routeIs('admin.promociones') ? 'active' : '' }}">
                <i class="fa-solid fa-ticket"></i> Promociones
            </li>
        </a>
        <a href="{{ route('admin.estadisticas') }}">
            <li class="{{ Request::routeIs('admin.estadisticas') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-line"></i> Estadísticas
            </li>
        </a>
        <a href="{{ route('admin.configuracion') }}">
            <li class="{{ Request::routeIs('admin.configuracion') ? 'active' : '' }}">
                <i class="fa-solid fa-gear"></i> Configuración
            </li>
        </a>
        <div class="sidebar-divider" style="height: 1px; background: rgba(255,255,255,0.1); margin: 1rem 0;"></div>
        <a href="{{ route('home') }}" target="_blank" rel="noopener">
            <li style="color: rgba(250,249,246,0.65);">
                <i class="fa-solid fa-store"></i> Ver Tienda
            </li>
        </a>
        <form action="{{ route('admin.logout') }}" method="POST" style="margin:0; padding:0;">
            @csrf
            <button type="submit" style="width:100%; background:transparent; border:none; cursor:pointer; padding:0; text-align:left;">
                <li style="color: #ff8a80;">
                    <i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesión
                </li>
            </button>
        </form>
    </ul>
</aside>
