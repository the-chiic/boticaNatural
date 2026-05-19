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
                            @forelse($direcciones as $direccion)
                                <div style="padding: 1.5rem; background: white; border-radius: 1rem; border: 1px solid rgba(27, 48, 34, 0.1);">
                                    @if($loop->first)
                                        <span style="font-size: 0.75rem; font-weight: bold; color: var(--brand-green);">PREDETERMINADA</span>
                                    @endif
                                    <p style="margin-top: 1rem; font-weight: bold;">{{ $direccion->address }}</p>
                                    <p style="font-size: 0.875rem; opacity: 0.7;">{{ $direccion->post_code }} {{ $direccion->city }}, {{ $direccion->province ?? '' }} ({{ $direccion->country }})</p>
                                    <p style="font-size: 0.75rem; opacity: 0.5; margin-top: 0.5rem;">Destinatario: {{ $direccion->name_destination ?? Auth::user()->name }}</p>
                                </div>
                            @empty
                                <div style="padding: 2rem; background: white; border-radius: 1rem; border: 1px dashed rgba(27, 48, 34, 0.2); grid-column: 1 / -1; text-align: center; opacity: 0.5;">
                                    No tienes ninguna dirección registrada.
                                </div>
                            @endforelse
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
        });
    </script>
@endpush
