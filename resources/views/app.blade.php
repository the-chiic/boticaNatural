<!DOCTYPE html>
<html lang="es">
    <head>
        @include('head')
        @stack('style')
        
        <!-- Estilos Responsivos Globales (Móvil y Tablet) -->
        <style>
            /* Tablet y pantallas medianas (menores a 992px) */
            @media (max-width: 992px) {
                .contenedorAutenticacion {
                    flex-direction: column !important;
                    min-height: auto !important;
                }
                .autenticacionIzquierda {
                    width: 100% !important;
                    padding: 3rem 1.5rem !important;
                }
                .autenticacionDerecha {
                    display: none !important; /* Oculta la imagen lateral para dar prioridad al formulario de login/recuperación */
                }
            }

            /* Móvil y Tablet (menores a 768px) */
            @media (max-width: 768px) {
                /* Perfil */
                .profile-layout {
                    flex-direction: column !important;
                    gap: 2rem !important;
                }
                .profile-nav {
                    width: 100% !important;
                    margin-bottom: 0 !important;
                    padding: 1.5rem !important;
                    border-radius: 1rem !important;
                }
                .profile-nav-link {
                    padding: 0.75rem 1rem !important;
                    border-radius: 0.5rem !important;
                }
                .order-history-table {
                    display: block !important;
                    width: 100% !important;
                    overflow-x: auto !important; /* Scroll horizontal elegante para tablas en móvil */
                    white-space: nowrap !important;
                    -webkit-overflow-scrolling: touch;
                }
                
                /* Catálogo */
                .catalog-layout {
                    flex-direction: column !important;
                    gap: 2rem !important;
                }
                .filters-sidebar {
                    width: 100% !important;
                    position: static !important;
                    padding: 1.5rem !important;
                    border-radius: 1rem !important;
                }
                .product-grid {
                    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)) !important; /* Cuadrícula optimizada de 2 columnas en móvil */
                    gap: 1rem !important;
                }
                .product-card {
                    border-radius: 0.75rem !important;
                }
                .product-details {
                    padding: 0.75rem !important;
                }
                .product-details h4 {
                    font-size: 0.9rem !important;
                }
                .price-label {
                    font-size: 1rem !important;
                }
            }
        </style>
    </head>
    <body>
        @php
            $activePromo = \App\Models\Promotion::where('is_active', true)
                ->where('show_on_web', true)
                ->where(function($q) {
                    $q->whereNull('starts_at')->orWhere('starts_at', '<=', now());
                })
                ->where(function($q) {
                    $q->whereNull('ends_at')->orWhere('ends_at', '>=', now());
                })
                ->orderBy('discount', 'desc')
                ->first();
        @endphp

        @if($activePromo)
            <div class="promo-announcement-bar">
                <span class="promo-icon"><i class="fa-solid fa-gift"></i></span>
                <span>
                    ¡PROMO ACTIVA! <strong>{{ $activePromo->name }}</strong>: Usa el cupón <strong class="promo-code">{{ $activePromo->code }}</strong> y obtén un <strong>{{ number_format($activePromo->discount, 0) }}% de descuento</strong> en tu compra.
                </span>
            </div>
        @endif

        @yield('navbar')

        <main>
            @yield('content')
        </main>

        @include('components.footer')

        @stack('scripts')
        
        <!-- Script Global de Favoritos con LocalStorage -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Cargar favoritos de localStorage
                let favoritos = JSON.parse(localStorage.getItem('favoritos')) || [];

                // Función para actualizar el estado visual de los corazones en la página
                function actualizarBotonesFavoritos() {
                    document.querySelectorAll('.btn-favorito').forEach(btn => {
                        const id = btn.getAttribute('data-id');
                        const icon = btn.querySelector('i');
                        if (favoritos.some(fav => fav.id === id)) {
                            btn.style.color = '#ef4444'; // rojo
                            icon.className = 'fa-solid fa-heart';
                        } else {
                            btn.style.color = '#ccc';
                            icon.className = 'fa-regular fa-heart';
                        }
                    });
                }

                // Gestionar clics en los botones de favoritos
                document.addEventListener('click', function(e) {
                    const btn = e.target.closest('.btn-favorito');
                    if (btn) {
                        e.preventDefault();
                        e.stopPropagation();
                        const id = btn.getAttribute('data-id');
                        const name = btn.getAttribute('data-name');
                        const image = btn.getAttribute('data-image');
                        const url = btn.getAttribute('data-url');
                        const price = btn.getAttribute('data-price');
                        const category = btn.getAttribute('data-category');

                        const index = favoritos.findIndex(fav => fav.id === id);
                        if (index > -1) {
                            favoritos.splice(index, 1); // eliminar
                        } else {
                            favoritos.push({ id, name, image, url, price, category }); // añadir
                        }
                        localStorage.setItem('favoritos', JSON.stringify(favoritos));
                        actualizarBotonesFavoritos();
                        
                        // Si estamos en la página de perfil, actualizar la lista en tiempo real
                        if (document.getElementById('tab-favoritos')) {
                            renderFavoritosPerfil();
                        }
                    }
                });

                // Inicializar botones en la página actual
                actualizarBotonesFavoritos();

                // Lógica específica para la pestaña de Favoritos en el Perfil
                function renderFavoritosPerfil() {
                    const container = document.getElementById('tab-favoritos');
                    if (!container) return;

                    if (favoritos.length === 0) {
                        container.innerHTML = `
                            <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 2rem;">MIS FAVORITOS</h2>
                            <p style="opacity: 0.5;">Aún no tienes productos en tu lista de deseos.</p>
                            <a href="${window.location.origin}/catalogo" class="btn-primary" style="display: inline-block; margin-top: 1rem; padding: 0.75rem 2rem; text-decoration: none; border-radius: 0.5rem;">IR A LA TIENDA</a>
                        `;
                    } else {
                        let html = `
                            <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 2rem;">MIS FAVORITOS</h2>
                            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1.5rem;">
                        `;

                        favoritos.forEach(prod => {
                            html += `
                                <div style="background: white; border-radius: 1rem; border: 1px solid rgba(27, 48, 34, 0.08); overflow: hidden; display: flex; flex-direction: column; position: relative; box-shadow: 0 4px 10px rgba(0,0,0,0.02);">
                                    <button class="btn-favorito" data-id="${prod.id}" style="position: absolute; top: 10px; right: 10px; z-index: 10; background: white; border: none; border-radius: 50%; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 5px rgba(0,0,0,0.1); cursor: pointer; color: #ef4444; transition: all 0.2s ease;">
                                        <i class="fa-solid fa-heart" style="font-size: 18px;"></i>
                                    </button>
                                    <a href="${prod.url}">
                                        <div style="width: 100%; padding-top: 100%; position: relative; background: #fafafa;">
                                            <img src="${prod.image}" alt="${prod.name}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                                        </div>
                                    </a>
                                    <div style="padding: 1rem; flex: 1; display: flex; flex-direction: column;">
                                        <span style="font-size: 10px; font-weight: 600; color: rgba(27, 48, 34, 0.45); text-transform: uppercase; letter-spacing: 0.15em; display: block; margin-bottom: 0.25rem;">
                                            ${prod.category}
                                        </span>
                                        <h4 style="font-size: 1rem; font-weight: bold; margin-bottom: 0.5rem; line-height: 1.3;">
                                            <a href="${prod.url}" style="color: var(--brand-green); text-decoration: none;">${prod.name}</a>
                                        </h4>
                                        <div style="display: flex; align-items: center; justify-content: space-between; margin-top: auto; padding-top: 0.5rem;">
                                            <span style="font-weight: 700; color: var(--brand-green);">${prod.price}</span>
                                            <a href="${prod.url}" class="btn-primary" style="padding: 0.4rem 1rem; font-size: 0.75rem; text-decoration: none; border-radius: 0.5rem;">Ver</a>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });

                        html += `</div>`;
                        container.innerHTML = html;
                    }
                }

                // Ejecutar el render si estamos en la vista de perfil
                if (document.getElementById('tab-favoritos')) {
                    renderFavoritosPerfil();
                }
            });
        </script>
    </body>
</html>
