@extends('landingPage')

@push('style')
    <link rel="stylesheet" href="{{ asset('css/styleProfile.css') }}">
    <style>
        .profile-tab-content { display: none; }
        .profile-tab-content.active { display: block; }
    </style>
@endpush

@section('main_content')
    <div class="section-padding" style="background: var(--brand-cream); min-height: 80vh;">
        <div class="container">
            <h1 class="section-title mb-8">MI CUENTA</h1>

            @if (session('success'))
                <div style="background-color: #dcfce7; color: #166534; padding: 1rem; border-radius: 0.5rem; margin-bottom: 2rem; font-size: 0.875rem; border: 1px solid #bbf7d0; text-align: center; font-weight: bold;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="profile-layout">
                <!-- Sidebar -->
                <aside class="profile-nav">
                    <div class="text-center mb-8">
                        <div style="width: 5rem; height: 5rem; background: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; font-size: 2rem; color: var(--brand-green); box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                            <i class="far fa-user"></i>
                        </div>
                        <h3 style="font-weight: bold; font-size: 1rem;">{{ Auth::user()->name }}</h3>
                        <p style="font-size: 0.75rem; opacity: 0.5;">{{ Auth::user()->email }}</p>
                    </div>

                    <nav id="profile-tabs">
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
                        <a href="/cerrar-sesion" class="profile-nav-link" style="color: #ff4d4d; margin-top: 2rem;">
                            <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                        </a>
                    </nav>
                </aside>

                <!-- Content -->
                <main class="profile-content-section">
                    
                    <!-- Tab: Pedidos -->
                    <div id="tab-pedidos" class="profile-tab-content active">
                        <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 2rem;">HISTORIAL DE PEDIDOS</h2>
                        <table class="order-history-table">
                            <thead>
                                <tr>
                                    <th>PEDIDO</th>
                                    <th>FECHA</th>
                                    <th>TOTAL</th>
                                    <th>ESTADO</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pedidos as $pedido)
                                    <tr>
                                        <td style="font-weight: bold;">#BN-{{ $pedido->id }}</td>
                                        <td>{{ \Carbon\Carbon::parse($pedido->order_date)->format('d M Y') }}</td>
                                        <td>{{ number_format($pedido->total_price, 2) }}€</td>
                                        <td>
                                            @if($pedido->status == 'completed' || $pedido->status == 'entregado')
                                                <span class="status-badge status-delivered">Entregado</span>
                                            @elseif($pedido->status == 'pending')
                                                <span class="status-badge status-pending" style="background: #fef3c7; color: #d97706; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem;">Pendiente</span>
                                            @else
                                                <span class="status-badge" style="background: #e5e7eb; color: #4b5563; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem;">{{ ucfirst($pedido->status) }}</span>
                                            @endif
                                        </td>
                                        <td style="text-align: right;"><a href="#" style="font-weight: bold; color: var(--brand-green); text-decoration: underline;">Ver detalle</a></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" style="text-align: center; opacity: 0.5; padding: 2rem;">Aún no tienes ningún pedido registrado.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Tab: Datos Personales -->
                    <div id="tab-datos" class="profile-tab-content">
                        <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 2rem;">DATOS PERSONALES</h2>
                        <form action="{{ route('profile.update') }}" method="POST" style="display: flex; flex-direction: column; gap: 1.5rem; max-width: 500px;">
                            @csrf
                            @method('PUT')
                            <div>
                                <label style="display: block; font-size: 0.75rem; font-weight: bold; margin-bottom: 0.5rem;">NOMBRE COMPLETO</label>
                                <input type="text" name="name" value="{{ Auth::user()->name }}" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.5rem;" required>
                            </div>
                            <div>
                                <label style="display: block; font-size: 0.75rem; font-weight: bold; margin-bottom: 0.5rem;">EMAIL</label>
                                <input type="email" value="{{ Auth::user()->email }}" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.5rem; background-color: #f3f4f6;" readonly>
                                <span style="font-size: 0.75rem; opacity: 0.5; margin-top: 0.25rem; display: block;">El correo electrónico no se puede modificar.</span>
                            </div>
                            <div>
                                <label style="display: block; font-size: 0.75rem; font-weight: bold; margin-bottom: 0.5rem;">TELÉFONO</label>
                                <input type="text" name="phone" value="{{ Auth::user()->phone }}" placeholder="Escribe tu teléfono" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.5rem;">
                            </div>
                            <button type="submit" class="btn-primary" style="align-self: flex-start; padding: 0.75rem 2rem; cursor: pointer;">GUARDAR CAMBIOS</button>
                        </form>
                    </div>

                    <!-- Tab: Direcciones -->
                    <div id="tab-direcciones" class="profile-tab-content">
                        <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 2rem;">MIS DIRECCIONES</h2>
                        
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                            @foreach($direcciones as $direccion)
                                <div style="padding: 1.5rem; background: white; border-radius: 1rem; border: 1px solid rgba(27, 48, 34, 0.1); position: relative; box-shadow: 0 2px 5px rgba(0,0,0,0.02);">
                                    @if($loop->first)
                                        <span style="font-size: 0.7rem; font-weight: bold; color: var(--brand-green); background: rgba(27, 48, 34, 0.05); padding: 0.25rem 0.5rem; border-radius: 0.25rem;">PREDETERMINADA</span>
                                    @endif
                                    <p style="margin-top: 1rem; font-weight: bold; color: var(--brand-green); font-size: 1rem;">{{ $direccion->address }}</p>
                                    <p style="font-size: 0.875rem; opacity: 0.8; margin-top: 0.5rem; line-height: 1.4;">{{ $direccion->post_code }} {{ $direccion->city }}, {{ $direccion->province ?? '' }} ({{ $direccion->country }})</p>
                                    <div style="border-top: 1px solid #f0f0f0; margin-top: 1rem; padding-top: 0.75rem; display: flex; flex-direction: column; gap: 0.25rem;">
                                        <p style="font-size: 0.75rem; opacity: 0.6;"><i class="far fa-user" style="margin-right: 0.25rem;"></i> {{ $direccion->name_destination ?? Auth::user()->name }}</p>
                                        @if($direccion->phone)
                                            <p style="font-size: 0.75rem; opacity: 0.6;"><i class="fas fa-phone" style="margin-right: 0.25rem;"></i> {{ $direccion->phone }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                            
                            <!-- Botón para abrir el formulario -->
                            <div id="btn-nueva-direccion" style="padding: 1.5rem; background: white; border-radius: 1rem; border: 1px dashed rgba(27, 48, 34, 0.3); display: flex; flex-direction: column; align-items: center; justify-content: center; cursor: pointer; min-height: 160px; transition: all 0.3s ease; text-align: center; box-sizing: border-box;" onmouseover="this.style.borderColor='var(--brand-green)'; this.style.backgroundColor='rgba(27, 48, 34, 0.02)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.borderColor='rgba(27, 48, 34, 0.3)'; this.style.backgroundColor='white'; this.style.transform='translateY(0)';">
                                <i class="fas fa-plus-circle" style="font-size: 2rem; color: var(--brand-green); margin-bottom: 0.5rem;"></i>
                                <span style="font-size: 0.875rem; font-weight: bold; color: var(--brand-green);">Añadir Dirección</span>
                            </div>
                        </div>

                        <!-- Formulario para Añadir Dirección (Oculto por defecto con transición elegante) -->
                        <div id="form-nueva-direccion" style="display: none; margin-top: 2rem; padding: 2rem; background: white; border-radius: 1rem; border: 1px solid rgba(27, 48, 34, 0.1); box-shadow: 0 10px 30px rgba(0,0,0,0.05); animation: fadeIn 0.3s ease-out;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid #f0f0f0; padding-bottom: 1rem;">
                                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--brand-green);">NUEVA DIRECCIÓN</h3>
                                <button type="button" id="btn-cancelar-direccion" style="background: none; border: none; font-size: 0.875rem; cursor: pointer; color: #ff4d4d; font-weight: bold; display: flex; align-items: center; gap: 0.25rem; padding: 0.5rem; border-radius: 0.25rem;">
                                    <i class="fas fa-times"></i> Cancelar
                                </button>
                            </div>
                            
                            <form action="{{ route('profile.address.add') }}" method="POST">
                                @csrf
                                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.25rem; margin-bottom: 1.5rem;">
                                    <div style="grid-column: 1 / -1;">
                                        <label style="display: block; font-size: 0.75rem; font-weight: bold; margin-bottom: 0.5rem; color: var(--brand-green);">DIRECCIÓN (Calle, número, piso, puerta)*</label>
                                        <input type="text" name="address" placeholder="Ej: Calle Gran Vía 45, 3ºB" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.5rem; box-sizing: border-box;" required>
                                    </div>
                                    <div>
                                        <label style="display: block; font-size: 0.75rem; font-weight: bold; margin-bottom: 0.5rem; color: var(--brand-green);">CIUDAD*</label>
                                        <input type="text" name="city" placeholder="Ej: Madrid" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.5rem; box-sizing: border-box;" required>
                                    </div>
                                    <div>
                                        <label style="display: block; font-size: 0.75rem; font-weight: bold; margin-bottom: 0.5rem; color: var(--brand-green);">PROVINCIA</label>
                                        <input type="text" name="province" placeholder="Ej: Madrid" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.5rem; box-sizing: border-box;">
                                    </div>
                                    <div>
                                        <label style="display: block; font-size: 0.75rem; font-weight: bold; margin-bottom: 0.5rem; color: var(--brand-green);">CÓDIGO POSTAL*</label>
                                        <input type="text" name="post_code" placeholder="Ej: 28013" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.5rem; box-sizing: border-box;" required>
                                    </div>
                                    <div>
                                        <label style="display: block; font-size: 0.75rem; font-weight: bold; margin-bottom: 0.5rem; color: var(--brand-green);">PAÍS*</label>
                                        <input type="text" name="country" value="España" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.5rem; box-sizing: border-box;" required>
                                    </div>
                                    <div>
                                        <label style="display: block; font-size: 0.75rem; font-weight: bold; margin-bottom: 0.5rem; color: var(--brand-green);">DESTINATARIO (Nombre completo)</label>
                                        <input type="text" name="name_destination" placeholder="Ej: Juan Pérez" value="{{ Auth::user()->name }}" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.5rem; box-sizing: border-box;">
                                    </div>
                                    <div>
                                        <label style="display: block; font-size: 0.75rem; font-weight: bold; margin-bottom: 0.5rem; color: var(--brand-green);">TELÉFONO DE CONTACTO</label>
                                        <input type="text" name="phone" placeholder="Ej: +34 600112233" value="{{ Auth::user()->phone }}" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.5rem; box-sizing: border-box;">
                                    </div>
                                </div>
                                <button type="submit" class="btn-primary" style="padding: 0.75rem 2rem; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; border-radius: 0.5rem; font-weight: bold;">
                                    <i class="fas fa-save"></i> GUARDAR DIRECCIÓN
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Tab: Favoritos -->
                    <div id="tab-favoritos" class="profile-tab-content">
                        <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 2rem;">MIS FAVORITOS</h2>
                        <p style="opacity: 0.5;">Aún no tienes productos en tu lista de deseos.</p>
                        <a href="/catalogo" class="btn-primary" style="display: inline-block; margin-top: 1rem; padding: 0.75rem 2rem;">IR A LA TIENDA</a>
                    </div>

                </main>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.profile-nav-link[data-tab]');
            const contents = document.querySelectorAll('.profile-tab-content');

            tabs.forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = this.getAttribute('data-tab');

                    // Remove active classes
                    tabs.forEach(t => t.classList.remove('active'));
                    contents.forEach(c => c.classList.remove('active'));

                    // Add active classes
                    this.classList.add('active');
                    document.getElementById('tab-' + target).classList.add('active');
                });
            });

            // Lógica para mostrar y ocultar el formulario de añadir dirección
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
        });
    </script>
@endpush
