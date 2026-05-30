<x-admin.layout title="Dashboard" subtitle="Bienvenido de nuevo al panel de administración.">
    <div class="stats">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-coins"></i>
            </div>
            <div class="stat-info">
                <h3>Ingresos Totales</h3>
                <p>€{{ number_format($totalRevenue, 2) }}</p>
                @if($revenueLastMonth > 0)
                    @php $revDelta = $revenueLastMonth > 0 ? round((($totalRevenue - $revenueLastMonth) / $revenueLastMonth) * 100, 1) : 0; @endphp
                    <span class="stat-delta {{ $revDelta >= 0 ? 'delta-up' : 'delta-down' }}">
                        <i class="fa-solid fa-arrow-{{ $revDelta >= 0 ? 'trend-up' : 'trend-down' }}"></i>
                        {{ $revDelta >= 0 ? '+' : '' }}{{ $revDelta }}% vs mes anterior
                    </span>
                @else
                    <span class="stat-delta delta-neutral"><i class="fa-solid fa-minus"></i> Sin datos previos</span>
                @endif
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-bag-shopping"></i>
            </div>
            <div class="stat-info">
                <h3>Total Pedidos</h3>
                <p>{{ $ordersCount }}</p>
                @php $orderDelta = $ordersLastMonth > 0 ? round((($ordersCount - $ordersLastMonth) / $ordersLastMonth) * 100, 1) : 0; @endphp
                @if($ordersLastMonth > 0)
                    <span class="stat-delta {{ $orderDelta >= 0 ? 'delta-up' : 'delta-down' }}">
                        <i class="fa-solid fa-arrow-{{ $orderDelta >= 0 ? 'trend-up' : 'trend-down' }}"></i>
                        {{ $orderDelta >= 0 ? '+' : '' }}{{ $orderDelta }}% vs mes anterior
                    </span>
                @else
                    <span class="stat-delta delta-neutral"><i class="fa-solid fa-minus"></i> Sin datos previos</span>
                @endif
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-users"></i>
            </div>
            <div class="stat-info">
                <h3>Clientes Registrados</h3>
                <p>{{ $customersCount }}</p>
                @php $custDelta = $customersLastMonth > 0 ? round((($customersCount - $customersLastMonth) / $customersLastMonth) * 100, 1) : 0; @endphp
                @if($customersLastMonth > 0)
                    <span class="stat-delta {{ $custDelta >= 0 ? 'delta-up' : 'delta-down' }}">
                        <i class="fa-solid fa-arrow-{{ $custDelta >= 0 ? 'trend-up' : 'trend-down' }}"></i>
                        {{ $custDelta >= 0 ? '+' : '' }}{{ $custDelta }}% vs mes anterior
                    </span>
                @else
                    <span class="stat-delta delta-neutral"><i class="fa-solid fa-minus"></i> Sin datos previos</span>
                @endif
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-box-open"></i>
            </div>
            <div class="stat-info">
                <h3>Productos Activos</h3>
                <p>{{ $activeProducts }}</p>
                <span class="stat-delta delta-neutral"><i class="fa-solid fa-circle-check"></i> En catálogo activo</span>
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

        <!-- Elegant Notepad / Quick Reminders Widget -->
        <div class="panel" style="margin-top: 30px;">
            <div class="panel-header" style="border-bottom: 1px solid rgba(139, 111, 74, 0.1); padding-bottom: 15px; margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center;">
                <h3 style="display: flex; align-items: center; gap: 8px; font-size: 16px;"><i class="fa-solid fa-note-sticky" style="color: var(--olive-green);"></i> Bloc de Notas y Remisiones</h3>
                <span id="saveStatus" style="font-size: 11px; color: var(--olive-green); opacity: 0; transition: opacity 0.3s;">Guardado</span>
            </div>
            <div class="notepad-body" style="display: flex; flex-direction: column; gap: 15px;">
                <p style="font-size: 12px; color: var(--olive-green); margin: 0; line-height: 1.5;">Usa este bloc para guardar recordatorios, fórmulas botánicas o notas de inventario. Se guardará automáticamente y persistirá entre sesiones.</p>
                <textarea id="adminNotepad" placeholder="Ej. Encargar frascos goteros de ámbar de 50ml..." style="width: 100%; min-height: 150px; padding: 15px; border: 1px solid var(--beige); border-radius: 12px; background-color: var(--cream); font-size: 13px; line-height: 1.6; color: var(--dark); resize: vertical; outline: none; transition: border-color 0.3s;" oninput="saveAdminNotes()"></textarea>
            </div>
        </div>
    </div>
</x-admin.layout>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Load saved notes from server
        const notepad = document.getElementById('adminNotepad');
        if (notepad) {
            fetch("{{ route('admin.notas.get') }}")
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        notepad.value = data.notes || '';
                    }
                })
                .catch(err => {
                    console.error('Error loading notes:', err);
                    // Fallback to localStorage
                    notepad.value = localStorage.getItem('botica_admin_notes') || '';
                });
        }
    });

    let autoSaveTimeout;
    function saveAdminNotes() {
        const notepad = document.getElementById('adminNotepad');
        const statusEl = document.getElementById('saveStatus');

        if (notepad) {
            // Save to server
            fetch("{{ route('admin.notas.save') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ notes: notepad.value })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Also save to localStorage as backup
                    localStorage.setItem('botica_admin_notes', notepad.value);

                    // Show "Guardado" status
                    if (statusEl) {
                        statusEl.style.opacity = '1';
                        clearTimeout(autoSaveTimeout);
                        autoSaveTimeout = setTimeout(() => {
                            statusEl.style.opacity = '0';
                        }, 1500);
                    }
                }
            })
            .catch(err => {
                console.error('Error saving notes:', err);
                // Fallback to localStorage
                localStorage.setItem('botica_admin_notes', notepad.value);
            });
        }
    }
</script>
@endpush
