<x-admin.layout title="Dashboard" subtitle="Bienvenido de nuevo al panel de administración.">
    <div class="stats">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-coins"></i>
            </div>
            <div class="stat-info">
                <h3>Ingresos Totales</h3>
                <p>€4,520.00</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-bag-shopping"></i>
            </div>
            <div class="stat-info">
                <h3>Nuevos Pedidos</h3>
                <p>85</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-users"></i>
            </div>
            <div class="stat-info">
                <h3>Nuevos Clientes</h3>
                <p>32</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-box-open"></i>
            </div>
            <div class="stat-info">
                <h3>Productos Activos</h3>
                <p>124</p>
            </div>
        </div>
    </div>

    <div class="panels-grid">
        <div class="panel">
            <div class="panel-header">
                <h3>Pedidos Recientes</h3>
                <a href="{{ route('admin.pedidos') }}" class="btn-link">Ver todos</a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>ID Pedido</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>#ORD-001</td>
                        <td>María González</td>
                        <td>10 May, 2026</td>
                        <td>€45.50</td>
                        <td><span class="status completed">Completado</span></td>
                    </tr>
                    <tr>
                        <td>#ORD-002</td>
                        <td>Juan Pérez</td>
                        <td>10 May, 2026</td>
                        <td>€120.00</td>
                        <td><span class="status pending">Pendiente</span></td>
                    </tr>
                    <tr>
                        <td>#ORD-003</td>
                        <td>Laura Martínez</td>
                        <td>09 May, 2026</td>
                        <td>€32.90</td>
                        <td><span class="status completed">Completado</span></td>
                    </tr>
                    <tr>
                        <td>#ORD-004</td>
                        <td>Carlos Ruiz</td>
                        <td>08 May, 2026</td>
                        <td>€85.00</td>
                        <td><span class="status completed">Completado</span></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="panel">
            <div class="panel-header">
                <h3>Productos Populares</h3>
                {{-- Link removed --}}
            </div>
            <div class="products-list">
                <div class="product">
                    <div class="thumb bg-olive"></div>
                    <div class="product-info">
                        <h4>Té Matcha Premium</h4>
                        <p>34 ventas</p>
                    </div>
                    <div class="price">€24.00</div>
                </div>
                <div class="product">
                    <div class="thumb bg-brown"></div>
                    <div class="product-info">
                        <h4>Aceite de Jojoba</h4>
                        <p>28 ventas</p>
                    </div>
                    <div class="price">€18.50</div>
                </div>
                <div class="product">
                    <div class="thumb bg-sage"></div>
                    <div class="product-info">
                        <h4>Infusión Relax</h4>
                        <p>22 ventas</p>
                    </div>
                    <div class="price">€12.00</div>
                </div>
            </div>
        </div>
    </div>
</x-admin.layout>
