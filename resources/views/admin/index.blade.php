<x-admin.layout title="Dashboard" subtitle="Bienvenido de nuevo al panel de administración.">
    <div class="stats">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-coins"></i>
            </div>
            <div class="stat-info">
                <h3>Ingresos Totales</h3>
                <p>€{{ number_format($totalRevenue, 2) }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-bag-shopping"></i>
            </div>
            <div class="stat-info">
                <h3>Total Pedidos</h3>
                <p>{{ $ordersCount }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-users"></i>
            </div>
            <div class="stat-info">
                <h3>Clientes Registrados</h3>
                <p>{{ $customersCount }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-box-open"></i>
            </div>
            <div class="stat-info">
                <h3>Productos Activos</h3>
                <p>{{ $activeProducts }}</p>
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
                        <th style="text-align: right;">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                        <tr onclick="window.location='{{ route('admin.pedidos') }}?open={{ $order->id }}&code={{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}&client={{ urlencode($order->user_name) }}'" style="cursor: pointer; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='rgba(107, 127, 90, 0.08)'" onmouseout="this.style.backgroundColor=''">
                            <td style="font-weight: 600; color: var(--dark-green);">#ORD-{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $order->user_name }}</td>
                            <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d M, Y') }}</td>
                            <td style="font-weight: 600;">€{{ number_format($order->total_price, 2) }}</td>
                            <td>
                                @if($order->status == 1)
                                    <span class="status completed">Completado</span>
                                @elseif($order->status == 0)
                                    <span class="status pending">Pendiente</span>
                                @else
                                    <span class="status" style="background-color: rgba(217, 48, 37, 0.1); color: #d93025;">Cancelado</span>
                                @endif
                            </td>
                            <td style="text-align: right;">
                                <button class="btn btn-sm btn-icon" style="padding: 4px 8px; font-size: 11px;">
                                    <i class="fa-solid fa-eye"></i> Ver
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: #888;">No hay pedidos registrados aún.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="panel">
            <div class="panel-header">
                <h3>Productos Populares</h3>
            </div>
            <div class="products-list">
                @php 
                    $colors = ['bg-olive', 'bg-brown', 'bg-sage', 'bg-dark']; 
                @endphp
                @forelse($popularProducts as $p)
                    <div class="product">
                        <div class="thumb {{ $colors[$loop->index % 4] }}">
                            {{ strtoupper(substr($p->name, 0, 1)) }}
                        </div>
                        <div class="product-info">
                            <h4>{{ $p->name }}</h4>
                            <p>{{ isset($p->sales_count) ? $p->sales_count : 0 }} ventas</p>
                        </div>
                        <div class="price">€{{ number_format($p->price, 2) }}</div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 20px; color: #888;">No hay productos registrados.</div>
                @endforelse
            </div>
        </div>
    </div>
</x-admin.layout>
