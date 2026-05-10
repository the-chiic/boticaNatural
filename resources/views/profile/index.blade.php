@extends('landingPage')

@push('style')
    <link rel="stylesheet" href="{{ asset('css/styleProfile.css') }}">
@endpush

@section('main_content')
    <div class="section-padding" style="background: var(--brand-cream); min-height: 80vh;">
        <div class="container">
            <h1 class="section-title mb-8">MI CUENTA</h1>

            <div class="profile-layout">
                <!-- Sidebar -->
                <aside class="profile-nav">
                    <div class="text-center mb-8">
                        <div style="width: 5rem; height: 5rem; background: var(--brand-cream); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; font-size: 2rem; color: var(--brand-green);">
                            <i class="far fa-user"></i>
                        </div>
                        <h3 style="font-weight: bold; font-size: 1rem;">Marta García</h3>
                        <p style="font-size: 0.75rem; opacity: 0.5;">marta@ejemplo.com</p>
                    </div>

                    <nav>
                        <a href="#" class="profile-nav-link active">
                            <i class="fas fa-shopping-bag"></i> Mis Pedidos
                        </a>
                        <a href="#" class="profile-nav-link">
                            <i class="fas fa-user-edit"></i> Datos Personales
                        </a>
                        <a href="#" class="profile-nav-link">
                            <i class="fas fa-map-marker-alt"></i> Direcciones
                        </a>
                        <a href="#" class="profile-nav-link">
                            <i class="fas fa-heart"></i> Favoritos
                        </a>
                        <a href="#" class="profile-nav-link" style="color: #ff4d4d; margin-top: 2rem;">
                            <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                        </a>
                    </nav>
                </aside>

                <!-- Content -->
                <main class="profile-content-section">
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
                            <tr>
                                <td style="font-weight: bold;">#BN-4921</td>
                                <td>10 May 2024</td>
                                <td>50.30€</td>
                                <td><span class="status-badge status-delivered">Entregado</span></td>
                                <td style="text-align: right;"><a href="#" style="font-weight: bold; color: var(--brand-green); text-decoration: underline;">Ver detalle</a></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;">#BN-4855</td>
                                <td>22 Abr 2024</td>
                                <td>24.90€</td>
                                <td><span class="status-badge status-delivered">Entregado</span></td>
                                <td style="text-align: right;"><a href="#" style="font-weight: bold; color: var(--brand-green); text-decoration: underline;">Ver detalle</a></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;">#BN-4712</td>
                                <td>05 Mar 2024</td>
                                <td>112.00€</td>
                                <td><span class="status-badge status-delivered">Entregado</span></td>
                                <td style="text-align: right;"><a href="#" style="font-weight: bold; color: var(--brand-green); text-decoration: underline;">Ver detalle</a></td>
                            </tr>
                        </tbody>
                    </table>
                </main>
            </div>
        </div>
    </div>
@endsection
