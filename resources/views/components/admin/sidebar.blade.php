<aside class="sidebar">
    <div class="sidebar-header">
        <i class="fa-solid fa-leaf sidebar-logo"></i>
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
        <a href="/">
            <li style="color: #ff6b6b;">
                <i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesión
            </li>
        </a>
    </ul>
</aside>
