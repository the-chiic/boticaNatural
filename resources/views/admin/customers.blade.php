<x-admin.layout title="Clientes" subtitle="Directorio de clientes registrados y CRM de compras.">
    <style>
        /* CRM Styles */
        .crm-grid {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 25px;
        }
        .crm-section-title {
            color: var(--dark-green);
            font-size: 13px;
            font-weight: 700;
            margin-top: 0;
            margin-bottom: 12px;
            border-bottom: 2px solid var(--beige);
            padding-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }
        .crm-info-card {
            background-color: var(--white);
            border: 1px solid var(--beige);
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }
        .crm-address-item {
            border-left: 3px solid var(--olive-green);
            background-color: rgba(107, 127, 90, 0.05);
            padding: 10px 14px;
            border-radius: 0 8px 8px 0;
            margin-bottom: 10px;
            font-size: 13px;
            line-height: 1.5;
            border-top: 1px solid rgba(107, 127, 90, 0.1);
            border-right: 1px solid rgba(107, 127, 90, 0.1);
            border-bottom: 1px solid rgba(107, 127, 90, 0.1);
        }
        .crm-order-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--beige);
            padding: 10px 0;
            font-size: 13px;
            transition: background-color 0.2s;
        }
        .crm-order-item:hover {
            background-color: rgba(0,0,0,0.01);
        }
    </style>

    <div class="panel">
        <div class="panel-header">
            <h3>Directorio de Clientes</h3>
        </div>

        <!-- Barra de Filtros SPA -->
        <div class="filter-bar-container" style="display: flex; gap: 15px; margin-bottom: 20px; padding: 15px; background-color: var(--cream); border: 1px solid var(--beige); border-radius: 10px;">
            <div style="flex: 1; position: relative;">
                <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--sage-green);"></i>
                <input type="text" id="spaSearchInput" placeholder="Buscar cliente por nombre, email o teléfono..." style="width: 100%; padding: 10px 15px 10px 42px; border: 1px solid var(--beige); border-radius: 20px; outline: none; font-size: 14px; background-color: var(--white); transition: border-color 0.2s;" onkeyup="filterCustomersTable()">
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Avatar</th>
                    <th>Nombre de Cliente</th>
                    <th>Correo Electrónico</th>
                    <th>Teléfono</th>
                    <th>Fecha de Registro</th>
                    <th style="text-align: center;">Pedidos</th>
                    <th style="text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @php 
                    $colors = ['bg-olive', 'bg-brown', 'bg-sage', 'bg-dark']; 
                @endphp
                @forelse($customers as $customer)
                    @php
                        $names = explode(' ', $customer->name);
                        $initials = strtoupper(substr($names[0], 0, 1));
                        if (count($names) > 1) {
                            $initials .= strtoupper(substr($names[1], 0, 1));
                        }
                    @endphp
                    <tr class="customer-row" data-name="{{ strtolower($customer->name) }}" data-email="{{ strtolower($customer->email) }}" data-phone="{{ strtolower($customer->phone) }}">
                        <td>
                            <div class="thumb {{ $colors[$loop->index % 4] }}" style="font-weight: 700; font-size: 13px; letter-spacing: 0.5px;">
                                {{ $initials }}
                            </div>
                        </td>
                        <td style="font-weight: 600; color: var(--dark-green);">{{ $customer->name }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->phone ?? 'Sin Teléfono' }}</td>
                        <td>{{ \Carbon\Carbon::parse($customer->created_at)->format('d M, Y') }}</td>
                        <td style="text-align: center; font-weight: 700; color: var(--olive-green);">
                            <span class="badge badge-success" style="font-size: 12px; padding: 4px 10px; border-radius: 20px;">
                                {{ $customer->orders_count }}
                            </span>
                        </td>
                        <td style="text-align: right;">
                            <button class="btn btn-sm btn-icon" onclick="loadCustomerCRM('{{ $customer->id }}', '{{ addslashes($customer->name) }}')">
                                <i class="fa-solid fa-address-card" style="margin-right: 4px;"></i> Ver Ficha
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: #888;">No se han encontrado registros de clientes.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal Box (Detalles CRM de Cliente) -->
    <div id="customerCRMModal" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-header">
                <h3 id="crmModalTitle">Ficha de Cliente</h3>
                <button class="modal-close" onclick="closeCRMModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="crm-grid">
                    <!-- Columna Izquierda: Datos Personales y Direcciones -->
                    <div>
                        <h4 class="crm-section-title">Datos Personales</h4>
                        <div class="crm-info-card" id="crmPersonalData">
                            <!-- Dinámico -->
                        </div>
                        
                        <h4 class="crm-section-title">Direcciones de Envío</h4>
                        <div id="crmAddressesList" style="max-height: 200px; overflow-y: auto; padding-right: 5px;">
                            <!-- Dinámico -->
                        </div>
                    </div>
                    
                    <!-- Columna Derecha: Historial de Compras -->
                    <div>
                        <h4 class="crm-section-title">Historial de Pedidos</h4>
                        <div id="crmOrdersList" style="max-height: 330px; overflow-y: auto; padding-right: 5px;">
                            <!-- Dinámico -->
                        </div>
                    </div>
                </div>
                
                <div class="form-actions" style="margin-top: 25px; border-top: 1px solid var(--beige); padding-top: 15px; text-align: right; margin-bottom: 0;">
                    <button type="button" class="btn" style="background-color: var(--sage-green);" onclick="closeCRMModal()">Cerrar Ficha</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const crmModal = document.getElementById('customerCRMModal');
        const crmTitle = document.getElementById('crmModalTitle');
        const crmPersonalData = document.getElementById('crmPersonalData');
        const crmAddressesList = document.getElementById('crmAddressesList');
        const crmOrdersList = document.getElementById('crmOrdersList');

        function loadCustomerCRM(id, name) {
            crmTitle.innerText = `Ficha de Cliente: ${name}`;

            crmPersonalData.innerHTML = `
                <p style="text-align: center; color: #888; padding: 10px; margin: 0; font-size: 13px;">
                    <i class="fa-solid fa-spinner fa-spin" style="margin-right: 6px;"></i> Cargando datos de contacto...
                </p>
            `;
            crmAddressesList.innerHTML = `
                <p style="text-align: center; color: #888; padding: 10px; margin: 0; font-size: 13px;">
                    <i class="fa-solid fa-spinner fa-spin" style="margin-right: 6px;"></i> Cargando direcciones...
                </p>
            `;
            crmOrdersList.innerHTML = `
                <p style="text-align: center; color: #888; padding: 20px; margin: 0; font-size: 13px;">
                    <i class="fa-solid fa-spinner fa-spin" style="margin-right: 6px;"></i> Obteniendo historial de pedidos...
                </p>
            `;

            crmModal.style.display = "flex";
            setTimeout(() => crmModal.classList.add('active'), 10);

            fetch("{{ route('admin.clientes.details', ':id') }}".replace(':id', id))
                .then(res => {
                    if (!res.ok) throw new Error('Error al cargar datos');
                    return res.json();
                })
                .then(data => {
                    const c = data.customer;
                    const addrs = data.addresses;
                    const ords = data.orders;

                    const dateObj = new Date(c.created_at);
                    const dateObj = new Date(c.created_at);
                    const formattedDate = dateObj.toLocaleDateString('es-ES', { day: '2-digit', month: 'short', year: 'numeric' });
                    crmPersonalData.innerHTML = `
                        <p style="margin: 5px 0; font-size: 13px; color: var(--dark-green);"><i class="fa-solid fa-user" style="width: 18px; opacity: 0.7;"></i> <strong>Nombre:</strong> ${c.name}</p>
                        <p style="margin: 5px 0; font-size: 13px; color: var(--dark-green);"><i class="fa-solid fa-envelope" style="width: 18px; opacity: 0.7;"></i> <strong>Email:</strong> ${c.email}</p>
                        <p style="margin: 5px 0; font-size: 13px; color: var(--dark-green);"><i class="fa-solid fa-phone" style="width: 18px; opacity: 0.7;"></i> <strong>Teléfono:</strong> ${c.phone || 'Sin Registrar'}</p>
                        <p style="margin: 5px 0; font-size: 13px; color: var(--dark-green);"><i class="fa-solid fa-calendar-day" style="width: 18px; opacity: 0.7;"></i> <strong>Registro:</strong> ${formattedDate}</p>
                    `;

                    if (addrs.length === 0) {
                        crmAddressesList.innerHTML = `
                            <div style="text-align: center; color: #888; font-style: italic; font-size: 13px; padding: 15px; border: 1px dashed var(--beige); border-radius: 8px;">
                                <i class="fa-solid fa-map-location-dot" style="font-size: 18px; margin-bottom: 6px; display: block; opacity: 0.5;"></i>
                                Ninguna dirección de envío registrada.
                            </div>
                        `;
                    } else {
                        let addrsHtml = '';
                        addrs.forEach(a => {
                            addrsHtml += `
                                <div class="crm-address-item">
                                    <strong><i class="fa-solid fa-location-dot"></i> ${a.name_destination || 'Dirección de Entrega'}</strong><br>
                                    <span style="opacity: 0.95;">${a.address}</span><br>
                                    <span style="opacity: 0.95;">${a.post_code || ''} ${a.city} (${a.province || ''})</span><br>
                                    <span style="font-size: 11px; color: var(--sage-green); font-weight: 600;">${a.country.toUpperCase()}</span>
                                    ${a.phone ? `<br><span style="font-size: 11px; opacity: 0.8;"><i class="fa-solid fa-phone" style="font-size:10px;"></i> ${a.phone}</span>` : ''}
                                </div>
                            `;
                        });
                        crmAddressesList.innerHTML = addrsHtml;
                    }

                    if (ords.length === 0) {
                        crmOrdersList.innerHTML = `
                            <div style="text-align: center; color: #888; font-style: italic; font-size: 13px; padding: 25px; border: 1px dashed var(--beige); border-radius: 8px;">
                                <i class="fa-solid fa-bag-shopping" style="font-size: 20px; margin-bottom: 6px; display: block; opacity: 0.5;"></i>
                                No hay pedidos registrados aún.
                            </div>
                        `;
                    } else {
                        let ordsHtml = '';
                        ords.forEach(o => {
                            const oDate = new Date(o.order_date).toLocaleDateString('es-ES', { 
                                day: '2-digit', 
                                month: '2-digit', 
                                year: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            });
                            
                            let statusBadge = '';
                            if (o.status == 1) {
                                statusBadge = `<span class="badge badge-success" style="font-size: 10px; padding: 3px 8px; border-radius: 10px;">Completado</span>`;
                            } else if (o.status == 0) {
                                statusBadge = `<span class="badge" style="background-color: var(--brown); color: var(--cream); font-size: 10px; padding: 3px 8px; border-radius: 10px;">Pendiente</span>`;
                            } else {
                                statusBadge = `<span class="badge badge-danger" style="font-size: 10px; padding: 3px 8px; border-radius: 10px;">Cancelado</span>`;
                            }
                            
                            ordsHtml += `
                                <div class="crm-order-item">
                                    <div>
                                        <div style="font-weight: 700; color: var(--dark-green); font-size: 13px;">
                                            #ORD-${String(o.id).padStart(3, '0')}
                                        </div>
                                        <div style="font-size: 11px; color: #888; margin-top: 2px;">
                                            <i class="fa-regular fa-clock"></i> ${oDate}
                                        </div>
                                    </div>
                                    <div style="text-align: right; display: flex; align-items: center; gap: 10px;">
                                        <div style="font-weight: 700; color: var(--olive-green); font-size: 14px;">
                                            €${parseFloat(o.total_price).toFixed(2)}
                                        </div>
                                        ${statusBadge}
                                        <a href="{{ url('/admin/pedidos') }}?open=${o.id}&code=${String(o.id).padStart(3, '0')}&client=${encodeURIComponent(c.name)}" class="btn-icon-link" title="Ver líneas y facturar" style="font-size: 15px; color: var(--sage-green); margin-left: 5px;">
                                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                        </a>
                                    </div>
                                </div>
                            `;
                        });
                        crmOrdersList.innerHTML = ordsHtml;
                    }
                })
                .catch(err => {
                    console.error(err);
                    crmPersonalData.innerHTML = `<p style="color: #d93025; font-size: 13px; text-align: center;">Error al obtener información.</p>`;
                    crmAddressesList.innerHTML = `<p style="color: #d93025; font-size: 13px; text-align: center;">Error.</p>`;
                    crmOrdersList.innerHTML = `<p style="color: #d93025; font-size: 13px; text-align: center;">Error.</p>`;
                });
        }

        function closeCRMModal() {
            crmModal.classList.remove('active');
            setTimeout(() => crmModal.style.display = "none", 300);
        }

        function filterCustomersTable() {
            const query = document.getElementById('spaSearchInput').value.toLowerCase().trim();
            const rows = document.querySelectorAll('.customer-row');
            
            rows.forEach(row => {
                const name = row.getAttribute('data-name');
                const email = row.getAttribute('data-email');
                const phone = row.getAttribute('data-phone');
                
                const matches = name.includes(query) || email.includes(query) || phone.includes(query);
                row.style.display = matches ? '' : 'none';
            });
        }

        window.onclick = function(event) {
            if (event.target == crmModal) {
                closeCRMModal();
            }
        }
    </script>
    @endpush
</x-admin.layout>
