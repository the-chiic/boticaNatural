<aside class="sidebar">
    <div class="sidebar-header">
        <i class="fa-solid fa-leaf sidebar-logo"></i>
        <h2>LA BOTICA NATURAL</h2>
        <p>NATURAL • PURO • CONSCIENTE</p>
    </div>
    <ul class="menu">
        <a href="{{ route('dashboard') }}">
            <li class="{{ Request::routeIs('dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-table-cells-large"></i> Dashboard
            </li>
        </a>
        <a href="{{ route('productos.index') }}">
            <li class="{{ Request::routeIs('productos.*') ? 'active' : '' }}">
                <i class="fa-solid fa-seedling"></i> Productos
            </li>
        </a>
        <a href="{{ route('pedidos.index') }}">
            <li class="{{ Request::routeIs('pedidos.*') ? 'active' : '' }}">
                <i class="fa-solid fa-bag-shopping"></i> Pedidos
            </li>
        </a>
        <a href="{{ route('clientes.index') }}">
            <li class="{{ Request::routeIs('clientes.*') ? 'active' : '' }}">
                <i class="fa-solid fa-users"></i> Clientes
            </li>
        </a>
        <a href="{{ route('estadisticas') }}">
            <li class="{{ Request::routeIs('estadisticas') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-line"></i> Estadísticas
            </li>
        </a>
        <a href="{{ route('configuracion') }}">
            <li class="{{ Request::routeIs('configuracion') ? 'active' : '' }}">
                <i class="fa-solid fa-gear"></i> Configuración
            </li>
        </a>
    </ul>
</aside>
