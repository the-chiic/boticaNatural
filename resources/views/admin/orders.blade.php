<x-admin.layout title="Pedidos" subtitle="Historial de pedidos de la tienda.">
    <style>
        .status-select {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            border: 1px solid var(--beige);
            outline: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .status-select.pending {
            background-color: rgba(139, 111, 74, 0.15);
            color: var(--brown);
            border-color: rgba(139, 111, 74, 0.3);
        }
        .status-select.completed {
            background-color: rgba(107, 127, 90, 0.15);
            color: var(--olive-green);
            border-color: rgba(107, 127, 90, 0.3);
        }
        .status-select.cancelled {
            background-color: rgba(217, 48, 37, 0.1);
            color: #d93025;
            border-color: rgba(217, 48, 37, 0.2);
        }

        .details-table th, .details-table td {
            padding: 12px;
            border-bottom: 1px solid var(--beige);
        }
        .details-table th {
            font-size: 11px;
            color: #888;
        }
    </style>

    @if(session('success'))
        <div class="alert-success">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    <div class="stats" style="grid-template-columns: repeat(3, 1fr); margin-bottom: 25px;">
        <div class="stat-card">
            <div class="stat-icon" style="background-color: rgba(139, 111, 74, 0.15); color: var(--brown);">
                <i class="fa-solid fa-clock"></i>
            </div>
            <div class="stat-info">
                <h3>Pedidos Pendientes</h3>
                <p>{{ $pendingCount }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background-color: rgba(107, 127, 90, 0.15); color: var(--olive-green);">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div class="stat-info">
                <h3>Pedidos Completados</h3>
                <p>{{ $completedCount }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background-color: rgba(217, 48, 37, 0.1); color: #d93025;">
                <i class="fa-solid fa-circle-xmark"></i>
            </div>
            <div class="stat-info">
                <h3>Pedidos Cancelados</h3>
                <p>{{ $cancelledCount }}</p>
            </div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">
            <h3>Gestión de Pedidos</h3>
            <a href="{{ route('admin.pedidos.export') }}" class="btn btn-sm" style="background-color: var(--olive-green);">
                <i class="fa-solid fa-file-excel btn-icon"></i> Exportar CSV
            </a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID Pedido</th>
                    <th>Cliente</th>
                    <th>Fecha de Compra</th>
                    <th>Estado de Envío</th>
                    <th>Total Pagado</th>
                    <th style="text-align: right;">Detalle</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td style="font-weight: 600; color: var(--dark-green);">#ORD-{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $order->user_name }}</td>
                        <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d M, Y - H:i') }}</td>
                        <td>
                            <form action="{{ route('admin.pedidos.status', $order->id) }}" method="POST" style="margin:0;">
                                @csrf
                                <select name="status" class="status-select @if($order->status == 1) completed @elseif($order->status == 0) pending @else cancelled @endif" onchange="this.form.submit()">
                                    <option value="0" @if($order->status == 0) selected @endif>Pendiente</option>
                                    <option value="1" @if($order->status == 1) selected @endif>Completado</option>
                                    <option value="2" @if($order->status == 2) selected @endif>Cancelado</option>
                                </select>
                            </form>
                        </td>
                        <td style="font-weight: 600;">€{{ number_format($order->total_price, 2) }}</td>
                        <td style="text-align: right;">
                            <button class="btn btn-sm btn-icon" onclick="loadOrderDetails('{{ $order->id }}', '{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}', '{{ $order->user_name }}')">
                                <i class="fa-solid fa-eye"></i> Ver artículos
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: #888;">No se han encontrado registros de pedidos.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($orders->lastPage() > 1)
        @php
            $paginator = $orders->withPath(url()->current())->appends(request()->query());
            $currentPage = $paginator->currentPage();
            $lastPage = $paginator->lastPage();
            $start = max($currentPage - 2, 1);
            $end = min($currentPage + 2, $lastPage);
        @endphp
        <div class="mt-6 flex justify-center pagination-container" style="display: flex; justify-content: center; align-items: center; gap: 0.5rem; width: 100%; margin-top: 2rem;">

            {{-- Double Left Arrow: Jumps to First Page (Page 1) --}}
            @if($paginator->onFirstPage())
                <span class="pagination-btn disabled" style="opacity: 0.5; cursor: not-allowed; border: 1px solid rgba(27,48,34,0.08); border-radius: 9999px; display: inline-flex; align-items: center; justify-content: center; background: white; color: #777; width: 2.4rem; height: 2.4rem; font-size: 0.8rem;">
                    <i class="fa-solid fa-angles-left"></i>
                </span>
            @else
                <a href="{{ $paginator->url(1) }}" class="pagination-btn" style="border: 1px solid rgba(27,48,34,0.08); border-radius: 9999px; display: inline-flex; align-items: center; justify-content: center; background: white; color: var(--brand-green, #1E3A2E); text-decoration: none; transition: all 0.2s; width: 2.4rem; height: 2.4rem; font-size: 0.8rem;" onmouseover="this.style.background='var(--brand-cream, #FAF9F6)'" onmouseout="this.style.background='white'">
                    <i class="fa-solid fa-angles-left"></i>
                </a>
            @endif

            {{-- Single Left Arrow: Jumps to Previous Page --}}
            @if($paginator->onFirstPage())
                <span class="pagination-btn disabled" style="opacity: 0.5; cursor: not-allowed; border: 1px solid rgba(27,48,34,0.08); border-radius: 9999px; display: inline-flex; align-items: center; justify-content: center; background: white; color: #777; width: 2.4rem; height: 2.4rem; font-size: 0.8rem;">
                    <i class="fa-solid fa-angle-left"></i>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="pagination-btn" style="border: 1px solid rgba(27,48,34,0.08); border-radius: 9999px; display: inline-flex; align-items: center; justify-content: center; background: white; color: var(--brand-green, #1E3A2E); text-decoration: none; transition: all 0.2s; width: 2.4rem; height: 2.4rem; font-size: 0.8rem;" onmouseover="this.style.background='var(--brand-cream, #FAF9F6)'" onmouseout="this.style.background='white'">
                    <i class="fa-solid fa-angle-left"></i>
                </a>
            @endif

            {{-- Page Numbers (Truncated with Ellipsis) --}}
            @if($start > 1)
                <a href="{{ $paginator->url(1) }}" class="pagination-btn" style="border: 1px solid rgba(27,48,34,0.08); border-radius: 9999px; display: inline-flex; align-items: center; justify-content: center; background: white; color: var(--brand-green, #1E3A2E); text-decoration: none; font-weight: 600; width: 2.4rem; height: 2.4rem; font-size: 0.8rem;" onmouseover="this.style.background='var(--brand-cream, #FAF9F6)'" onmouseout="this.style.background='white'">1</a>
                @if($start > 2)
                    <span style="color: rgba(27,48,34,0.5); padding: 0 0.25rem;">...</span>
                @endif
            @endif

            @for($i = $start; $i <= $end; $i++)
                @if($i == $currentPage)
                    <span class="pagination-btn active" style="background: var(--brand-green, #1E3A2E); color: white; border: 1px solid var(--brand-green, #1E3A2E); border-radius: 9999px; font-weight: 700; display: inline-flex; align-items: center; justify-content: center; width: 2.4rem; height: 2.4rem; font-size: 0.8rem; box-shadow: 0 4px 10px rgba(30, 58, 46, 0.15);">
                        {{ $i }}
                    </span>
                @else
                    <a href="{{ $paginator->url($i) }}" class="pagination-btn" style="border: 1px solid rgba(27,48,34,0.08); border-radius: 9999px; display: inline-flex; align-items: center; justify-content: center; background: white; color: var(--brand-green, #1E3A2E); text-decoration: none; font-weight: 600; transition: all 0.2s; width: 2.4rem; height: 2.4rem; font-size: 0.8rem;" onmouseover="this.style.background='var(--brand-cream, #FAF9F6)'" onmouseout="this.style.background='white'">
                        {{ $i }}
                    </a>
                @endif
            @endfor

            @if($end < $lastPage)
                @if($end < $lastPage - 1)
                    <span style="color: rgba(27,48,34,0.5); padding: 0 0.25rem;">...</span>
                @endif
                <a href="{{ $paginator->url($lastPage) }}" class="pagination-btn" style="border: 1px solid rgba(27,48,34,0.08); border-radius: 9999px; display: inline-flex; align-items: center; justify-content: center; background: white; color: var(--brand-green, #1E3A2E); text-decoration: none; font-weight: 600; width: 2.4rem; height: 2.4rem; font-size: 0.8rem;" onmouseover="this.style.background='var(--brand-cream, #FAF9F6)'" onmouseout="this.style.background='white'">{{ $lastPage }}</a>
            @endif

            {{-- Single Right Arrow: Jumps to Next Page --}}
            @if($paginator->currentPage() == $paginator->lastPage())
                <span class="pagination-btn disabled" style="opacity: 0.5; cursor: not-allowed; border: 1px solid rgba(27,48,34,0.08); border-radius: 9999px; display: inline-flex; align-items: center; justify-content: center; background: white; color: #777; width: 2.4rem; height: 2.4rem; font-size: 0.8rem;">
                    <i class="fa-solid fa-angle-right"></i>
                </span>
            @else
                <a href="{{ $paginator->nextPageUrl() }}" class="pagination-btn" style="border: 1px solid rgba(27,48,34,0.08); border-radius: 9999px; display: inline-flex; align-items: center; justify-content: center; background: white; color: var(--brand-green, #1E3A2E); text-decoration: none; transition: all 0.2s; width: 2.4rem; height: 2.4rem; font-size: 0.8rem;" onmouseover="this.style.background='var(--brand-cream, #FAF9F6)'" onmouseout="this.style.background='white'">
                    <i class="fa-solid fa-angle-right"></i>
                </a>
            @endif

            {{-- Double Right Arrow: Jumps to Last Page --}}
            @if($paginator->currentPage() == $paginator->lastPage())
                <span class="pagination-btn disabled" style="opacity: 0.5; cursor: not-allowed; border: 1px solid rgba(27,48,34,0.08); border-radius: 9999px; display: inline-flex; align-items: center; justify-content: center; background: white; color: #777; width: 2.4rem; height: 2.4rem; font-size: 0.8rem;">
                    <i class="fa-solid fa-angles-right"></i>
                </span>
            @else
                <a href="{{ $paginator->url($paginator->lastPage()) }}" class="pagination-btn" style="border: 1px solid rgba(27,48,34,0.08); border-radius: 9999px; display: inline-flex; align-items: center; justify-content: center; background: white; color: var(--brand-green, #1E3A2E); text-decoration: none; transition: all 0.2s; width: 2.4rem; height: 2.4rem; font-size: 0.8rem;" onmouseover="this.style.background='var(--brand-cream, #FAF9F6)'" onmouseout="this.style.background='white'">
                    <i class="fa-solid fa-angles-right"></i>
                </a>
            @endif

        </div>
        @endif
    </div>

    <!-- Modal Box (Detalles de pedido) -->
    <div id="orderDetailsModal" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-header">
                <h3 id="modalTitle">Detalle de Pedido #ORD-000</h3>
                <button class="modal-close" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div style="margin-bottom: 20px;">
                    <p style="font-size: 14px; color: #666;">
                        <strong>Cliente:</strong> <span id="detailClientName">Cargando...</span>
                    </p>
                </div>
                
                <table class="details-table" style="width:100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 2px solid var(--beige);">
                            <th>Producto</th>
                            <th style="text-align: center;">Cantidad</th>
                            <th style="text-align: right;">P. Unitario</th>
                            <th style="text-align: right;">Total</th>
                        </tr>
                    </thead>
                    <tbody id="orderDetailsBody">
                        <tr>
                            <td colspan="4" style="text-align: center; color: #888; padding: 20px;">Cargando líneas de compra...</td>
                        </tr>
                    </tbody>
                </table>
                
                <div style="text-align: right; margin-top: 25px; padding-top: 15px; border-top: 2px solid var(--beige);">
                    <h4 style="color: var(--dark-green); font-size: 18px;">
                        Total Compra: <span id="detailTotalPrice">€0.00</span>
                    </h4>
                </div>
                
                <div class="form-actions" style="margin-top: 20px; display: flex; justify-content: space-between; align-items: center;">
                    <button type="button" class="btn" style="background-color: var(--olive-green);" onclick="printInvoice()">
                        <i class="fa-solid fa-print btn-icon"></i> Imprimir Factura
                    </button>
                    <button type="button" class="btn" onclick="closeModal()">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const modal = document.getElementById('orderDetailsModal');
        const modalTitle = document.getElementById('modalTitle');
        const detailClientName = document.getElementById('detailClientName');
        const orderDetailsBody = document.getElementById('orderDetailsBody');
        const detailTotalPrice = document.getElementById('detailTotalPrice');

        let currentOrder = {
            id: '',
            code: '',
            clientName: '',
            lines: []
        };

        function loadOrderDetails(id, orderCode, clientName) {
            currentOrder.id = id;
            currentOrder.code = orderCode;
            currentOrder.clientName = clientName;
            currentOrder.lines = [];

            modalTitle.innerText = `Detalle de Pedido #ORD-${orderCode}`;
            detailClientName.innerText = clientName;
            
            orderDetailsBody.innerHTML = `
                <tr>
                    <td colspan="4" style="text-align: center; padding: 20px; color: #888;">
                        <i class="fa-solid fa-spinner fa-spin" style="margin-right: 8px;"></i> Obteniendo información de la base de datos...
                    </td>
                </tr>
            `;
            detailTotalPrice.innerText = '€0.00';
            
            modal.style.display = "flex";
            setTimeout(() => modal.classList.add('active'), 10);
            
            fetch("{{ route('admin.pedidos.details', ':id') }}".replace(':id', id), {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Error ${response.status}: ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(lines => {
                    let html = '';
                    let sum = 0;

                    if(lines.length === 0) {
                        orderDetailsBody.innerHTML = `
                            <tr>
                                <td colspan="4" style="text-align: center; color: #888; padding: 20px;">No se encontraron artículos en este pedido.</td>
                            </tr>
                        `;
                        return;
                    }

                    lines.forEach(line => {
                        currentOrder.lines.push(line);
                        const lineTotal = parseFloat(line.total_price);
                        sum += lineTotal;

                        html += `
                            <tr>
                                <td style="font-weight: 500; color: var(--dark-green);">${line.product_name}</td>
                                <td style="text-align: center; font-weight: 600;">${line.unit}</td>
                                <td style="text-align: right;">€${parseFloat(line.unit_price).toFixed(2)}</td>
                                <td style="text-align: right; font-weight: 600;">€${lineTotal.toFixed(2)}</td>
                            </tr>
                        `;
                    });

                    orderDetailsBody.innerHTML = html;
                    detailTotalPrice.innerText = `€${sum.toFixed(2)}`;
                })
                .catch(err => {
                    console.error(err);
                    orderDetailsBody.innerHTML = `
                        <tr>
                            <td colspan="4" style="text-align: center; color: #d93025; padding: 20px;">Error al cargar las líneas del pedido: ${err.message}</td>
                        </tr>
                    `;
                });
        }

        function printInvoice() {
            if (!currentOrder.code || currentOrder.lines.length === 0) {
                alert('No hay datos disponibles para imprimir.');
                return;
            }
            
            const printWindow = window.open('', '_blank', 'width=800,height=600');
            if (!printWindow) {
                alert('Por favor, permite las ventanas emergentes en tu navegador para imprimir la factura.');
                return;
            }
            
            let itemsHtml = '';
            let total = 0;
            currentOrder.lines.forEach(line => {
                const lineTotal = parseFloat(line.total_price);
                total += lineTotal;
                itemsHtml += `
                    <tr>
                        <td>${line.product_name}</td>
                        <td style="text-align: center;">${line.unit}</td>
                        <td style="text-align: right;">€${parseFloat(line.unit_price).toFixed(2)}</td>
                        <td style="text-align: right; font-weight: bold;">€${lineTotal.toFixed(2)}</td>
                    </tr>
                `;
            });
            
            const invoiceHtml = `
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura_ORD-${currentOrder.code}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            padding: 40px;
            background-color: #fff;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #1E3A2E;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo-title h1 {
            color: #1E3A2E;
            margin: 0;
            font-size: 28px;
            letter-spacing: 1px;
            font-weight: 700;
        }
        .logo-title p {
            color: #6B7F5A;
            margin: 5px 0 0;
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-weight: 600;
        }
        .invoice-details {
            text-align: right;
        }
        .invoice-details h2 {
            margin: 0;
            color: #1E3A2E;
            font-size: 20px;
            font-weight: 700;
        }
        .invoice-details p {
            margin: 5px 0 0;
            font-size: 14px;
            color: #666;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
        }
        .info-block h3 {
            color: #1E3A2E;
            border-bottom: 1px solid #EDE7DB;
            padding-bottom: 5px;
            margin-bottom: 10px;
            font-size: 13px;
            text-transform: uppercase;
            font-weight: 600;
        }
        .info-block p {
            margin: 4px 0;
            font-size: 14px;
            line-height: 1.5;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 35px;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #EDE7DB;
            font-size: 14px;
        }
        th {
            background-color: #FAF9F6;
            color: #1E3A2E;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
            font-weight: 600;
        }
        .total-section {
            text-align: right;
            margin-top: 20px;
        }
        .total-box {
            display: inline-block;
            background-color: #FAF9F6;
            border: 1px solid #EDE7DB;
            padding: 15px 30px;
            border-radius: 8px;
        }
        .total-box h4 {
            margin: 0;
            color: #1E3A2E;
            font-size: 18px;
            font-weight: 700;
        }
        .footer {
            margin-top: 60px;
            border-top: 1px solid #EDE7DB;
            padding-top: 20px;
            text-align: center;
            font-size: 11px;
            color: #888;
            line-height: 1.6;
        }
        @media print {
            body {
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo-title">
            <h1>{{ Cache::get('shop_name', 'LA BOTICA NATURAL') }}</h1>
            <p>Herbolario & Cosmética Natural</p>
        </div>
        <div class="invoice-details">
            <h2>FACTURA COMPRA</h2>
            <p><strong>Nº Factura:</strong> #FAC-${currentOrder.code}</p>
            <p><strong>Fecha Emisión:</strong> ${new Date().toLocaleDateString('es-ES', { day: '2-digit', month: 'long', year: 'numeric' })}</p>
        </div>
    </div>

    <div class="info-grid">
        <div class="info-block">
            <h3>Datos del Emisor</h3>
            <p><strong>{{ Cache::get('shop_name', 'La Botica Natural S.L.') }}</strong></p>
            <p>NIF: {{ Cache::get('shop_nif', 'B-12345678') }}</p>
            <p style="white-space: pre-line;">{{ Cache::get('shop_address', "Calle de la Naturaleza, 42\n28014 Madrid, España") }}</p>
            <p>{{ Cache::get('shop_email', 'contacto@laboticanatural.com') }}</p>
        </div>
        <div class="info-block">
            <h3>Facturado a</h3>
            <p><strong>${currentOrder.clientName}</strong></p>
            <p>Cliente Registrado</p>
            <p>España</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Descripción del Artículo</th>
                <th style="text-align: center; width: 100px;">Cantidad</th>
                <th style="text-align: right; width: 120px;">Precio Unitario</th>
                <th style="text-align: right; width: 120px;">Total</th>
            </tr>
        </thead>
        <tbody>
            ${itemsHtml}
        </tbody>
    </table>

    <div class="total-section">
        <div class="total-box">
            <h4>Total Factura: €${total.toFixed(2)}</h4>
        </div>
    </div>

    <div class="footer">
        <p>Gracias por confiar en el bienestar de la naturaleza.</p>
        <p>{{ Cache::get('shop_name', 'La Botica Natural S.L.') }} · NIF: {{ Cache::get('shop_nif', 'B-12345678') }} · {{ Cache::get('shop_email', 'contacto@laboticanatural.com') }}</p>
    </div>

    <script>
        window.onload = function() {
            setTimeout(function() {
                window.print();
                setTimeout(function() { window.close(); }, 500);
            }, 300);
        }
    <\/script>
</body>
</html>
            `;
            
            printWindow.document.open();
            printWindow.document.write(invoiceHtml);
            printWindow.document.close();
        }

        function closeModal() {
            modal.classList.remove('active');
            setTimeout(() => modal.style.display = "none", 300);
        }

        window.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const openId = urlParams.get('open');
            const openCode = urlParams.get('code');
            const openClient = urlParams.get('client');

            if (openId && openCode && openClient) {
                loadOrderDetails(openId, openCode, decodeURIComponent(openClient));

                const cleanUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
                window.history.replaceState({path: cleanUrl}, '', cleanUrl);
            }
        });

        window.onclick = function(event) {
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
    @endpush
</x-admin.layout>
