@extends('landingPage')

@push('style')
    <link rel="stylesheet" href="{{ asset('css/styleProfile.css') }}">
    <style>
        .profile-tab-content { display: none; }
        .profile-tab-content.active { display: block; }
    </style>
@endpush

@section('main_content')
    <div class="section-padding" style="background: var(--color-fondo, #FAF9F6); min-height: 85vh; padding: 4rem 0;">
        <div class="container">
            <h1 class="section-title mb-8" style="font-family: var(--fuente-base); font-weight: 700; color: var(--color-principal, #1E3A2E); letter-spacing: -0.01em; margin-bottom: 2.5rem; text-transform: uppercase;">Mi Cuenta</h1>

            @if (session('success'))
                <div style="background-color: #e6f7ed; color: #1b8a5a; padding: 1.25rem; border-radius: 1rem; margin-bottom: 2.5rem; font-size: 0.9rem; border: 1px solid rgba(27, 88, 58, 0.08); text-align: center; font-weight: 700; box-shadow: 0 4px 12px rgba(27, 48, 34, 0.02); animation: fadeInSlide 0.4s ease-out;">
                    <i class="fas fa-check-circle" style="margin-right: 0.5rem;"></i> {{ session('success') }}
                </div>
            @endif

            <div class="profile-layout">
                <!-- Sidebar -->
                <aside class="profile-nav">
                    <div class="profile-avatar-wrapper">
                        <div class="profile-avatar-ring"></div>
                        <div class="profile-avatar-circle">
                            <i class="far fa-user"></i>
                        </div>
                    </div>
                    
                    <div class="profile-user-info">
                        <h3 class="profile-user-name">{{ Auth::user()->name }}</h3>
                        <p class="profile-user-email">{{ Auth::user()->email }}</p>
                    </div>

                    <!-- Estadísticas Rápidas de Perfil -->
                    <div class="profile-stats-grid">
                        <div class="profile-stat-card">
                            <span class="profile-stat-num">{{ count($pedidos) }}</span>
                            <span class="profile-stat-lbl">Pedidos</span>
                        </div>
                        <div class="profile-stat-card">
                            <span class="profile-stat-num">{{ count($direcciones) }}</span>
                            <span class="profile-stat-lbl">Dir.</span>
                        </div>
                        <div class="profile-stat-card">
                            <span class="profile-stat-num" id="stats-favoritos-count">0</span>
                            <span class="profile-stat-lbl">Fav.</span>
                        </div>
                    </div>

                    <nav class="profile-menu">
                        <a href="#" class="profile-nav-link active" data-tab="pedidos">
                            <i class="fas fa-shopping-bag"></i> Mis Pedidos
                        </a>
                        <a href="#" class="profile-nav-link" data-tab="datos">
                            <i class="fas fa-user-edit"></i> Datos Personales
                        </a>
                        <a href="#" class="profile-nav-link" data-tab="direcciones">
                            <i class="fas fa-map-marker-alt"></i> Direcciones
                        </a>
                        <a href="#" class="profile-nav-link" data-tab="favoritos">
                            <i class="fas fa-heart"></i> Favoritos
                        </a>
                        <a href="{{ url('cerrar-sesion') }}" class="profile-nav-link logout-btn">
                            <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                        </a>
                    </nav>
                </aside>

                <!-- Content -->
                <main class="profile-content-section">
                    
                    <!-- Tab: Pedidos -->
                    <div id="tab-pedidos" class="profile-tab-content active">
                        <h2 class="tab-title"><i class="fas fa-shopping-bag" style="color: var(--color-acento, #8B6F4A); margin-right: 0.25rem;"></i> Historial de Pedidos</h2>
                        
                        <div class="orders-list">
                            @forelse($pedidos as $pedido)
                                <div class="order-card">
                                    <div class="order-header">
                                        <div class="order-meta-info">
                                            <div class="order-meta-block">
                                                <span class="order-meta-lbl">Pedido</span>
                                                <span class="order-meta-val order-id">#BN-{{ $pedido->id }}</span>
                                            </div>
                                            <div class="order-meta-block">
                                                <span class="order-meta-lbl">Fecha</span>
                                                <span class="order-meta-val">{{ \Carbon\Carbon::parse($pedido->order_date)->format('d M Y') }}</span>
                                            </div>
                                            <div class="order-meta-block">
                                                <span class="order-meta-lbl">Total</span>
                                                <span class="order-meta-val">{{ number_format($pedido->total_price, 2) }}€</span>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            @if($pedido->status == 'completed' || $pedido->status == 'entregado' || $pedido->status == '1')
                                                <span class="status-badge status-delivered">Entregado</span>
                                            @elseif($pedido->status == 'pending' || $pedido->status == '0')
                                                <span class="status-badge status-pending">Pendiente</span>
                                            @else
                                                <span class="status-badge status-cancelled">Cancelado</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Timeline Tracker Visual -->
                                    @php
                                        $isDelivered = ($pedido->status == 'completed' || $pedido->status == 'entregado' || $pedido->status == '1');
                                        $isPending = ($pedido->status == 'pending' || $pedido->status == '0');
                                        $isCancelled = ($pedido->status == 'cancelled' || $pedido->status == '2');
                                    @endphp
                                    
                                    @if(!$isCancelled)
                                        <div class="order-timeline-container">
                                            <div class="order-timeline">
                                                <div class="order-timeline-progress" style="width: {{ $isDelivered ? '100%' : '50%' }};"></div>
                                                
                                                <div class="timeline-step completed">
                                                    <div class="timeline-dot"></div>
                                                    <span class="timeline-label">Recibido</span>
                                                </div>
                                                <div class="timeline-step {{ $isDelivered ? 'completed' : 'active' }}">
                                                    <div class="timeline-dot"></div>
                                                    <span class="timeline-label">Preparación</span>
                                                </div>
                                                <div class="timeline-step {{ $isDelivered ? 'completed' : '' }}">
                                                    <div class="timeline-dot"></div>
                                                    <span class="timeline-label">Entregado</span>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div style="background: #fdf2f2; color: #df1b1b; padding: 0.75rem 1.25rem; border-radius: 0.75rem; font-size: 0.8rem; font-weight: 700; margin-bottom: 1.5rem; text-align: center; border: 1px solid rgba(223, 27, 27, 0.08);">
                                            Este pedido ha sido cancelado. Si tienes dudas, por favor contáctanos.
                                        </div>
                                    @endif

                                    <div class="order-footer">
                                        <div class="order-total-price">
                                            Total Pagado: <span>{{ number_format($pedido->total_price, 2) }}€</span>
                                        </div>
                                        <button class="btn-detail-trigger" data-order-id="{{ $pedido->id }}">
                                            <i class="fas fa-eye"></i> Ver Detalle
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div class="empty-tab-state">
                                    <i class="fas fa-shopping-bag"></i>
                                    <p>Aún no tienes ningún pedido registrado en tu cuenta.</p>
                                    <a href="/catalogo" class="btn-submit-premium" style="display: inline-block; text-decoration: none;">IR A LA TIENDA</a>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Tab: Datos Personales -->
                    <div id="tab-datos" class="profile-tab-content">
                        <h2 class="tab-title"><i class="fas fa-user-edit" style="color: var(--color-acento, #8B6F4A); margin-right: 0.25rem;"></i> Datos Personales</h2>
                        
                        <form action="{{ route('profile.update') }}" method="POST" class="luxury-form">
                            @csrf
                            @method('PUT')
                            
                            <div class="form-grid-2">
                                <div class="form-group">
                                    <label class="form-label">Nombre Completo</label>
                                    <input type="text" name="name" value="{{ Auth::user()->name }}" class="form-input" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Teléfono Móvil</label>
                                    <input type="text" name="phone" value="{{ Auth::user()->phone }}" placeholder="Escribe tu teléfono" class="form-input">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Correo Electrónico</label>
                                <input type="email" value="{{ Auth::user()->email }}" class="form-input" readonly>
                                <span class="form-tip">El correo electrónico está vinculado a tu cuenta y no se puede modificar por motivos de seguridad.</span>
                            </div>
                            
                            <button type="submit" class="btn-submit-premium">GUARDAR CAMBIOS</button>
                        </form>
                    </div>

                    <!-- Tab: Direcciones -->
                    <div id="tab-direcciones" class="profile-tab-content">
                        <h2 class="tab-title"><i class="fas fa-map-marker-alt" style="color: var(--color-acento, #8B6F4A); margin-right: 0.25rem;"></i> Mis Direcciones</h2>
                        
                        <div class="address-grid">
                            @foreach($direcciones as $direccion)
                                <div class="address-card">
                                    <div>
                                        @if($loop->first)
                                            <span class="address-default-badge">Predeterminada</span>
                                        @endif
                                        
                                        <div class="address-body">
                                            <p class="address-street">{{ $direccion->address }}</p>
                                            <p class="address-city">{{ $direccion->post_code }} {{ $direccion->city }}{{ $direccion->province ? ', ' . $direccion->province : '' }} ({{ $direccion->country }})</p>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <div class="address-footer-info">
                                            <span style="font-weight: 700; display: inline-flex; align-items: center; gap: 0.3rem; color: var(--color-principal);"><i class="far fa-user"></i> {{ $direccion->name_destination ?? Auth::user()->name }}</span>
                                            @if($direccion->phone)
                                                <span style="display: inline-flex; align-items: center; gap: 0.3rem;"><i class="fas fa-phone"></i> {{ $direccion->phone }}</span>
                                            @endif
                                        </div>
                                        
                                        <div class="address-actions">
                                            <form action="{{ route('profile.address.delete', $direccion->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta dirección?');" style="margin: 0; display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-address-delete">
                                                    <i class="far fa-trash-alt"></i> Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            
                            <!-- Botón para abrir el formulario -->
                            <div id="btn-nueva-direccion" class="btn-add-address-card">
                                <i class="fas fa-plus"></i>
                                <span>Añadir Dirección</span>
                            </div>
                        </div>

                        <!-- Formulario para Añadir Dirección (Oculto por defecto) -->
                        <div id="form-nueva-direccion" class="form-address-wrapper">
                            <div class="form-address-header">
                                <h3 class="form-address-title">NUEVA DIRECCIÓN DE ENVÍO</h3>
                                <button type="button" id="btn-cancelar-direccion" class="btn-close-form">
                                    <i class="fas fa-times"></i> Cancelar
                                </button>
                            </div>
                            
                            <form action="{{ route('profile.address.add') }}" method="POST" class="luxury-form">
                                @csrf
                                <div class="form-group" style="margin-bottom: 1.25rem;">
                                    <label class="form-label">Dirección Completa (Calle, número, piso, puerta)*</label>
                                    <input type="text" name="address" placeholder="Ej: Calle Gran Vía 45, 3ºB" class="form-input" required>
                                </div>
                                
                                <div class="form-grid-2" style="margin-bottom: 1.25rem;">
                                    <div class="form-group">
                                        <label class="form-label">Ciudad*</label>
                                        <input type="text" name="city" placeholder="Ej: Madrid" class="form-input" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Provincia</label>
                                        <input type="text" name="province" placeholder="Ej: Madrid" class="form-input">
                                    </div>
                                </div>
                                
                                <div class="form-grid-2" style="margin-bottom: 1.25rem;">
                                    <div class="form-group">
                                        <label class="form-label">Código Postal*</label>
                                        <input type="text" name="post_code" placeholder="Ej: 28013" class="form-input" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">País*</label>
                                        <input type="text" name="country" value="España" class="form-input" required>
                                    </div>
                                </div>
                                
                                <div class="form-grid-2" style="margin-bottom: 1.75rem;">
                                    <div class="form-group">
                                        <label class="form-label">Destinatario (Nombre Completo)</label>
                                        <input type="text" name="name_destination" value="{{ Auth::user()->name }}" placeholder="Nombre de quien recibe" class="form-input">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Teléfono de Contacto</label>
                                        <input type="text" name="phone" value="{{ Auth::user()->phone }}" placeholder="Teléfono para el repartidor" class="form-input">
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn-submit-premium">
                                    <i class="fas fa-save" style="margin-right: 0.25rem;"></i> GUARDAR DIRECCIÓN
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Tab: Favoritos -->
                    <div id="tab-favoritos" class="profile-tab-content">
                        <!-- El script global se encarga de renderizar esto si hay elementos -->
                    </div>

                </main>
            </div>
        </div>
    </div>

    <!-- Modal de Detalle de Pedido -->
    <div id="order-detail-modal" class="luxury-modal-overlay">
        <div class="luxury-modal">
            <div class="modal-header">
                <span class="modal-title" id="modal-order-title">DETALLE DE PEDIDO</span>
                <button type="button" class="modal-close-icon" id="btn-close-modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <!-- Loader -->
                <div id="modal-loader" class="modal-loader">
                    <div class="spinner-luxury"></div>
                    <p>Cargando información del pedido...</p>
                </div>
                
                <!-- Contenido -->
                <div id="modal-content" style="display: none;">
                    <div class="modal-items-list" id="modal-items-container">
                        <!-- Cargado dinámicamente con JS -->
                    </div>
                    
                    <div class="modal-summary-card">
                        <h4 class="modal-summary-title">Resumen de Pago</h4>
                        <div class="modal-summary-row">
                            <span>Subtotal de Artículos</span>
                            <span id="modal-summary-subtotal">0.00€</span>
                        </div>
                        <div class="modal-summary-row">
                            <span>Gastos de Envío</span>
                            <span id="modal-summary-shipping">0.00€</span>
                        </div>
                        <div class="modal-summary-row modal-total">
                            <span>Total del Pedido</span>
                            <strong id="modal-summary-total">0.00€</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- GESTIÓN DE PESTAÑAS (TABS) ---
            const tabs = document.querySelectorAll('.profile-nav-link[data-tab]');
            const contents = document.querySelectorAll('.profile-tab-content');

            tabs.forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = this.getAttribute('data-tab');

                    // Desactivar todas las pestañas y contenidos
                    tabs.forEach(t => t.classList.remove('active'));
                    contents.forEach(c => c.classList.remove('active'));

                    // Activar la seleccionada
                    this.classList.add('active');
                    const targetEl = document.getElementById('tab-' + target);
                    if (targetEl) {
                        targetEl.classList.add('active');
                    }
                });
            });

            // --- SINCRONIZAR ESTADÍSTICAS RÁPIDAS (FAVORITOS DE LOCALSTORAGE) ---
            const favs = JSON.parse(localStorage.getItem('favoritos')) || [];
            const favsCountEl = document.getElementById('stats-favoritos-count');
            if (favsCountEl) {
                favsCountEl.textContent = favs.length;
            }

            // --- GESTIÓN DE NUEVA DIRECCIÓN ---
            const btnNuevaDireccion = document.getElementById('btn-nueva-direccion');
            const formNuevaDireccion = document.getElementById('form-nueva-direccion');
            const btnCancelarDireccion = document.getElementById('btn-cancelar-direccion');

            if (btnNuevaDireccion && formNuevaDireccion && btnCancelarDireccion) {
                btnNuevaDireccion.addEventListener('click', function() {
                    formNuevaDireccion.style.display = 'block';
                    formNuevaDireccion.scrollIntoView({ behavior: 'smooth', block: 'start' });
                });

                btnCancelarDireccion.addEventListener('click', function() {
                    formNuevaDireccion.style.display = 'none';
                });
            }

            // --- DETALLES DE PEDIDO POR AJAX + MODAL PREMIUM ---
            const modal = document.getElementById('order-detail-modal');
            const modalTitle = document.getElementById('modal-order-title');
            const modalLoader = document.getElementById('modal-loader');
            const modalContent = document.getElementById('modal-content');
            const itemsContainer = document.getElementById('modal-items-container');
            
            const subtotalEl = document.getElementById('modal-summary-subtotal');
            const shippingEl = document.getElementById('modal-summary-shipping');
            const totalEl = document.getElementById('modal-summary-total');

            const btnCloseModal = document.getElementById('btn-close-modal');
            
            // Abrir modal y cargar datos por AJAX
            document.querySelectorAll('.btn-detail-trigger').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const orderId = this.getAttribute('data-order-id');
                    
                    // Mostrar modal vacío con Loader
                    modalTitle.textContent = `DETALLE DE PEDIDO #BN-${orderId}`;
                    modalLoader.style.display = 'flex';
                    modalContent.style.display = 'none';
                    modal.classList.add('active');

                    // Petición AJAX segura
                    fetch(`${window.location.origin}/perfil/pedido/${orderId}/detalles`)
                        .then(response => {
                            if (!response.ok) throw new Error('Error al recuperar detalles');
                            return response.json();
                        })
                        .then(data => {
                            const order = data.order;
                            const lines = data.lines;

                            // Limpiar contenedor de artículos
                            itemsContainer.innerHTML = '';
                            
                            let subtotalCalculado = 0;

                            // Iterar e insertar las líneas
                            lines.forEach(line => {
                                const price = parseFloat(line.price || line.total_price);
                                const unitPrice = price / line.unit;
                                subtotalCalculado += price;

                                const imgUrl = line.product_image 
                                    ? `${window.location.origin}/storage/${line.product_image}` 
                                    : `${window.location.origin}/img/imgPrueba.png`;

                                itemsContainer.innerHTML += `
                                    <div class="modal-item-row">
                                        <div class="modal-item-img-wrapper">
                                            <img src="${imgUrl}" alt="${line.product_name}" onerror="this.src='${window.location.origin}/img/imgPrueba.png';">
                                        </div>
                                        <div class="modal-item-details">
                                            <h5 class="modal-item-name">${line.product_name}</h5>
                                            <span class="modal-item-qty">Cantidad: ${line.unit} × ${unitPrice.toFixed(2)}€</span>
                                        </div>
                                        <div class="modal-item-price">${price.toFixed(2)}€</div>
                                    </div>
                                `;
                            });

                            // Actualizar Resumen de Precios
                            const orderTotal = parseFloat(order.total_price);
                            const shippingCost = orderTotal - subtotalCalculado;

                            subtotalEl.textContent = `${subtotalCalculado.toFixed(2)}€`;
                            shippingEl.textContent = shippingCost > 0 ? `${shippingCost.toFixed(2)}€` : 'Gratis';
                            totalEl.textContent = `${orderTotal.toFixed(2)}€`;

                            // Ocultar Loader y Mostrar Contenido
                            modalLoader.style.display = 'none';
                            modalContent.style.display = 'block';
                        })
                        .catch(err => {
                            console.error(err);
                            itemsContainer.innerHTML = `<div style="text-align: center; color: #cc2d2d; font-weight: 700; padding: 2rem 0;">Error al cargar los detalles del pedido. Inténtalo de nuevo.</div>`;
                            modalLoader.style.display = 'none';
                            modalContent.style.display = 'block';
                        });
                });
            });

            // Cerrar Modal
            function cerrarModal() {
                modal.classList.remove('active');
            }

            if (btnCloseModal) {
                btnCloseModal.addEventListener('click', cerrarModal);
            }

            // Cerrar modal al hacer clic en el overlay exterior
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    cerrarModal();
                }
            });

            // Cerrar modal con la tecla Escape
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && modal.classList.contains('active')) {
                    cerrarModal();
                }
            });
        });
    </script>
@endpush

