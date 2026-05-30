<x-admin.layout title="Promociones" subtitle="Gestión de cupones de descuento y campañas comerciales.">

    @if(session('success'))
        <div class="alert-success">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    <div class="panel">
        <div class="panel-header">
            <h3>Cupones de Descuento</h3>
            <button class="btn btn-sm" onclick="openAddModal()">
                <i class="fa-solid fa-plus btn-icon"></i> Crear Cupón
            </button>
        </div>

        <!-- Barra de Filtros SPA -->
        <div class="filter-bar-container" style="display: flex; gap: 15px; margin-bottom: 20px; padding: 15px; background-color: var(--cream); border: 1px solid var(--beige); border-radius: 10px;">
            <div style="flex: 1; position: relative;">
                <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--sage-green);"></i>
                <input type="text" id="spaSearchInput" placeholder="Buscar cupón por nombre o código..." style="width: 100%; padding: 10px 15px 10px 42px; border: 1px solid var(--beige); border-radius: 20px; outline: none; font-size: 14px; background-color: var(--white); transition: border-color 0.2s;" onkeyup="filterPromotionsTable()">
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Icono</th>
                    <th>Campaña / Nombre</th>
                    <th>Código de Cupón</th>
                    <th>Descuento</th>
                    <th>Vigencia</th>
                    <th>Estado</th>
                    <th>Ver en Web</th>
                    <th style="text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @php 
                    $colors = ['bg-olive', 'bg-brown', 'bg-sage', 'bg-dark']; 
                @endphp
                @forelse($promotions as $promotion)
                    @php
                        $isExpired = false;
                        if ($promotion->ends_at && $promotion->ends_at->isPast()) {
                            $isExpired = true;
                        }
                    @endphp
                    <tr class="promotion-row" data-name="{{ strtolower($promotion->name) }}" data-code="{{ strtolower($promotion->code) }}">
                        <td>
                            <div class="thumb {{ $colors[$loop->index % 4] }}">
                                <i class="fa-solid fa-ticket" style="font-size: 16px;"></i>
                            </div>
                        </td>
                        <td style="font-weight: 600; color: var(--dark-green);">{{ $promotion->name }}</td>
                        <td>
                            <span class="code-badge">{{ $promotion->code }}</span>
                        </td>
                        <td style="font-weight: 700; color: var(--olive-green); font-size: 15px;">
                            {{ number_format($promotion->discount, 0) }}%
                        </td>
                        <td>
                            <div style="font-size: 13px; color: var(--dark-green);">
                                @if($promotion->starts_at || $promotion->ends_at)
                                    <div>
                                        <i class="fa-regular fa-calendar-check" style="margin-right: 4px; opacity: 0.7;"></i>
                                        <strong>Inicio:</strong> {{ $promotion->starts_at ? $promotion->starts_at->format('d/m/Y') : 'Inmediato' }}
                                    </div>
                                    <div>
                                        <i class="fa-regular fa-calendar-times" style="margin-right: 4px; opacity: 0.7;"></i>
                                        <strong>Fin:</strong> {{ $promotion->ends_at ? $promotion->ends_at->format('d/m/Y') : 'Indefinido' }}
                                    </div>
                                @else
                                    <span style="color: #888; font-style: italic;">Sin límite temporal</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <button type="button" class="status-toggle-btn" 
                                onclick="togglePromotionStatus({{ $promotion->id }}, this)" 
                                data-active="{{ $promotion->is_active ? 1 : 0 }}" 
                                data-expired="{{ $isExpired ? 1 : 0 }}"
                                style="border: none; background: transparent; padding: 0; cursor: pointer; outline: none;"
                                title="{{ $isExpired ? 'Esta promoción ha expirado' : 'Haga clic para alternar estado' }}"
                                {{ $isExpired ? 'disabled' : '' }}>
                                @if(!$promotion->is_active)
                                    <span class="badge badge-danger" style="display: inline-flex; align-items: center; gap: 4px; transition: all 0.2s; cursor: pointer;"><i class="fa-solid fa-toggle-off" style="font-size: 14px; opacity: 0.85;"></i> Inactivo</span>
                                @elseif($isExpired)
                                    <span class="badge badge-danger" style="background-color: var(--brown); color: var(--cream); display: inline-flex; align-items: center; gap: 4px; cursor: not-allowed;"><i class="fa-solid fa-circle-exclamation" style="font-size: 11px;"></i> Expirado</span>
                                @else
                                    <span class="badge badge-success" style="display: inline-flex; align-items: center; gap: 4px; transition: all 0.2s; cursor: pointer;"><i class="fa-solid fa-toggle-on" style="font-size: 14px; opacity: 0.85;"></i> Activo</span>
                                @endif
                            </button>
                        </td>
                        <td>
                            <button type="button" class="web-toggle-btn" 
                                onclick="togglePromotionWeb({{ $promotion->id }}, this)" 
                                data-show="{{ $promotion->show_on_web ? 1 : 0 }}" 
                                style="border: none; background: transparent; padding: 0; cursor: pointer; outline: none;"
                                title="Alternar visibilidad en la web de clientes">
                                @if($promotion->show_on_web)
                                    <span class="badge badge-success" style="background-color: var(--olive-green); color: var(--white); display: inline-flex; align-items: center; gap: 4px; transition: all 0.2s; cursor: pointer;"><i class="fa-solid fa-eye" style="font-size: 13px;"></i> Visible</span>
                                @else
                                    <span class="badge badge-danger" style="background-color: var(--sage-green); color: var(--dark-green); display: inline-flex; align-items: center; gap: 4px; transition: all 0.2s; cursor: pointer;"><i class="fa-solid fa-eye-slash" style="font-size: 13px;"></i> Oculto</span>
                                @endif
                            </button>
                        </td>
                        <td style="text-align: right;">
                            <button class="btn-icon-link edit" title="Editar" 
                                onclick="openEditModal(JSON.parse(this.getAttribute('data-promotion')))"
                                data-promotion="{{ json_encode([
                                    'id' => $promotion->id,
                                    'name' => $promotion->name,
                                    'code' => $promotion->code,
                                    'discount' => $promotion->discount,
                                    'is_active' => $promotion->is_active ? 1 : 0,
                                    'show_on_web' => $promotion->show_on_web ? 1 : 0,
                                    'starts_at' => $promotion->starts_at ? $promotion->starts_at->format('Y-m-d') : '',
                                    'ends_at' => $promotion->ends_at ? $promotion->ends_at->format('Y-m-d') : ''
                                ]) }}">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <form action="{{ route('admin.promociones.delete', $promotion->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este cupón permanentemente? Se desvinculará de todos los productos.')">
                                @csrf
                                <button type="submit" class="btn-icon-link delete" title="Eliminar">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: #888;">No hay cupones de descuento registrados en el sistema.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal Box -->
    <div id="promotionModal" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-header">
                <h3 id="modalTitle">Nuevo Cupón de Descuento</h3>
                <button class="modal-close" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body">
                <form id="promotionForm" action="{{ route('admin.promociones.store') }}" method="POST">
                    @csrf
                    <input type="hidden" id="promotion_id" name="id">
                    
                    <div class="form-group">
                        <label for="name">Nombre de la Promoción / Campaña</label>
                        <input type="text" id="name" name="name" required placeholder="Ej. Descuento de Primavera">
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="code">Código del Cupón</label>
                            <input type="text" id="code" name="code" required placeholder="Ej. PRIMAVERA20" style="text-transform: uppercase;">
                            <small style="color: #666; font-size: 11px;">El código se convertirá automáticamente a mayúsculas.</small>
                        </div>
                        <div class="form-group">
                            <label for="discount">Porcentaje de Descuento (%)</label>
                            <input type="number" id="discount" name="discount" step="0.01" min="0" max="100" required placeholder="Ej. 15.00">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="starts_at">Fecha de Inicio (Opcional)</label>
                            <input type="date" id="starts_at" name="starts_at">
                        </div>
                        <div class="form-group">
                            <label for="ends_at">Fecha de Finalización (Opcional)</label>
                            <input type="date" id="ends_at" name="ends_at">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="is_active">Estado Inicial</label>
                            <select id="is_active" name="is_active" required>
                                <option value="1" selected>Activo (Habilitado para compras)</option>
                                <option value="0">Inactivo (Deshabilitado)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="show_on_web">Mostrar en Web de Clientes</label>
                            <select id="show_on_web" name="show_on_web" required>
                                <option value="1" selected>Visible (Mostrar banner)</option>
                                <option value="0">Oculto (Ocultar banner)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-actions" style="margin-top: 25px;">
                        <button type="button" class="btn" style="background-color: var(--sage-green); margin-right: 10px;" onclick="closeModal()">Cancelar</button>
                        <button type="submit" class="btn">Guardar Cupón</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const modal = document.getElementById('promotionModal');
        const form = document.getElementById('promotionForm');
        const modalTitle = document.getElementById('modalTitle');
        const storeUrl = "{{ route('admin.promociones.store') }}";

        function openAddModal() {
            modalTitle.innerText = "Nuevo Cupón de Descuento";
            form.action = storeUrl;
            form.reset();
            document.getElementById('promotion_id').value = "";
            document.getElementById('is_active').value = "1";
            document.getElementById('show_on_web').value = "1";
            
            modal.style.display = "flex";
            setTimeout(() => modal.classList.add('active'), 10);
        }

        function openEditModal(promotion) {
            modalTitle.innerText = "Editar Cupón de Descuento";
            form.action = "{{ url('/admin/promociones') }}/" + promotion.id;

            document.getElementById('promotion_id').value = promotion.id;
            document.getElementById('name').value = promotion.name;
            document.getElementById('code').value = promotion.code;
            document.getElementById('discount').value = parseFloat(promotion.discount);
            document.getElementById('is_active').value = promotion.is_active;
            document.getElementById('show_on_web').value = promotion.show_on_web;
            document.getElementById('starts_at').value = promotion.starts_at;
            document.getElementById('ends_at').value = promotion.ends_at;

            modal.style.display = "flex";
            setTimeout(() => modal.classList.add('active'), 10);
        }

        function closeModal() {
            modal.classList.remove('active');
            setTimeout(() => modal.style.display = "none", 300);
        }

        function filterPromotionsTable() {
            const searchQuery = document.getElementById('spaSearchInput').value.toLowerCase().trim();
            const rows = document.querySelectorAll('.promotion-row');
            
            rows.forEach(row => {
                const name = row.getAttribute('data-name');
                const code = row.getAttribute('data-code');
                
                const matchesSearch = name.includes(searchQuery) || code.includes(searchQuery);
                
                if (matchesSearch) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function togglePromotionStatus(id, buttonEl) {
            if (buttonEl.getAttribute('data-expired') === '1') {
                return;
            }

            const currentActive = parseInt(buttonEl.getAttribute('data-active'));
            const newActive = currentActive === 1 ? 0 : 1;
            
            buttonEl.style.opacity = '0.5';
            buttonEl.style.pointerEvents = 'none';

            fetch("{{ url('/admin/promociones') }}/" + id + "/toggle", {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                buttonEl.style.opacity = '1';
                buttonEl.style.pointerEvents = 'auto';

                if (data.success) {
                    const isActive = data.is_active;
                    buttonEl.setAttribute('data-active', isActive ? '1' : '0');
                    
                    if (isActive) {
                        buttonEl.innerHTML = `<span class="badge badge-success" style="display: inline-flex; align-items: center; gap: 4px; transition: all 0.2s; cursor: pointer;"><i class="fa-solid fa-toggle-on" style="font-size: 14px; opacity: 0.85;"></i> Activo</span>`;
                        
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: `¡Cupón ${data.code} activado!`,
                            text: 'Aparecerá en la cabecera de la web del cliente.',
                            showConfirmButton: false,
                            timer: 3500,
                            timerProgressBar: true,
                            background: '#FAF9F6',
                            color: '#1E3A2E',
                            iconColor: '#6B7F5A'
                        });
                    } else {
                        buttonEl.innerHTML = `<span class="badge badge-danger" style="display: inline-flex; align-items: center; gap: 4px; transition: all 0.2s; cursor: pointer;"><i class="fa-solid fa-toggle-off" style="font-size: 14px; opacity: 0.85;"></i> Inactivo</span>`;
                        
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'info',
                            title: `Cupón ${data.code} desactivado`,
                            text: 'Se ha retirado de la web del cliente.',
                            showConfirmButton: false,
                            timer: 3500,
                            timerProgressBar: true,
                            background: '#FAF9F6',
                            color: '#1E3A2E',
                            iconColor: '#8B6F4A'
                        });
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo actualizar el estado del cupón.',
                        confirmButtonColor: '#1E3A2E'
                    });
                }
            })
            .catch(error => {
                buttonEl.style.opacity = '1';
                buttonEl.style.pointerEvents = 'auto';
                console.error('Error toggling promotion status:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error de Red',
                    text: 'Hubo un problema de conexión al cambiar el estado.',
                    confirmButtonColor: '#1E3A2E'
                });
            });
        }

        function togglePromotionWeb(id, buttonEl) {
            const currentShow = parseInt(buttonEl.getAttribute('data-show'));
            
            buttonEl.style.opacity = '0.5';
            buttonEl.style.pointerEvents = 'none';

            fetch("{{ url('/admin/promociones') }}/" + id + "/toggle-web", {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                buttonEl.style.opacity = '1';
                buttonEl.style.pointerEvents = 'auto';

                if (data.success) {
                    const isShow = data.show_on_web;
                    buttonEl.setAttribute('data-show', isShow ? '1' : '0');
                    
                    if (isShow) {
                        buttonEl.innerHTML = `<span class="badge badge-success" style="background-color: var(--olive-green); color: var(--white); display: inline-flex; align-items: center; gap: 4px; transition: all 0.2s; cursor: pointer;"><i class="fa-solid fa-eye" style="font-size: 13px;"></i> Visible</span>`;
                        
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: `¡Banner del cupón ${data.code} visible!`,
                            text: 'Se mostrará en la cabecera de la web pública.',
                            showConfirmButton: false,
                            timer: 3500,
                            timerProgressBar: true,
                            background: '#FAF9F6',
                            color: '#1E3A2E',
                            iconColor: '#6B7F5A'
                        });
                    } else {
                        buttonEl.innerHTML = `<span class="badge badge-danger" style="background-color: var(--sage-green); color: var(--dark-green); display: inline-flex; align-items: center; gap: 4px; transition: all 0.2s; cursor: pointer;"><i class="fa-solid fa-eye-slash" style="font-size: 13px;"></i> Oculto</span>`;
                        
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'info',
                            title: `Banner del cupón ${data.code} oculto`,
                            text: 'Se ha retirado de la cabecera de la web pública.',
                            showConfirmButton: false,
                            timer: 3500,
                            timerProgressBar: true,
                            background: '#FAF9F6',
                            color: '#1E3A2E',
                            iconColor: '#8B6F4A'
                        });
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo actualizar la visibilidad del cupón.',
                        confirmButtonColor: '#1E3A2E'
                    });
                }
            })
            .catch(error => {
                buttonEl.style.opacity = '1';
                buttonEl.style.pointerEvents = 'auto';
                console.error('Error toggling promotion web status:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error de Red',
                    text: 'Hubo un problema de conexión al cambiar la visibilidad.',
                    confirmButtonColor: '#1E3A2E'
                });
            });
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
    @endpush
</x-admin.layout>
