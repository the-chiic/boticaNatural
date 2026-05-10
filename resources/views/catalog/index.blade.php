@extends('landingPage')

@push('style')
    <link rel="stylesheet" href="{{ asset('css/styleCatalog.css') }}">
@endpush

@section('main_content')
    <div class="section-padding" style="background: var(--brand-cream); min-height: 100vh;">
        <div class="container">
            <!-- Breadcrumbs -->
            <div class="mb-8" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em; color: rgba(27, 48, 34, 0.4);">
                <a href="/">Inicio</a> / <span style="color: var(--brand-green);">Catálogo</span>
            </div>

            <h1 class="section-title">TODOS LOS PRODUCTOS</h1>

            <div class="catalog-layout">
                <!-- Filters -->
                <aside class="filters-sidebar">
                    <div class="filter-group">
                        <span class="filter-title">Categorías</span>
                        <ul class="filter-list">
                            <li><a href="#" class="filter-link active">Todos <span>(24)</span></a></li>
                            <li><a href="#" class="filter-link">Infusiones <span class="count-badge">8</span></a></li>
                            <li><a href="#" class="filter-link">Aceites <span class="count-badge">6</span></a></li>
                            <li><a href="#" class="filter-link">Cosmética <span class="count-badge">10</span></a></li>
                        </ul>
                    </div>

                    <div class="filter-group">
                        <span class="filter-title">Precio</span>
                        <div style="padding: 0 0.5rem;">
                            <input type="range" style="width: 100%; accent-color: var(--brand-green);">
                            <div class="flex justify-between mt-6" style="font-size: 0.75rem; font-weight: bold;">
                                <span>0€</span>
                                <span>100€</span>
                            </div>
                        </div>
                    </div>

                    <div class="filter-group">
                        <span class="filter-title">Beneficios</span>
                        <ul class="filter-list">
                            <li><label class="flex items-center gap-2" style="font-size: 0.875rem; color: rgba(27, 48, 34, 0.6);"><input type="checkbox"> Relajante</label></li>
                            <li><label class="flex items-center gap-2" style="font-size: 0.875rem; color: rgba(27, 48, 34, 0.6);"><input type="checkbox"> Energizante</label></li>
                            <li><label class="flex items-center gap-2" style="font-size: 0.875rem; color: rgba(27, 48, 34, 0.6);"><input type="checkbox"> Detox</label></li>
                        </ul>
                    </div>
                </aside>

                <!-- Products -->
                <main>
                    <div class="catalog-header">
                        <span style="font-size: 0.875rem; color: rgba(27, 48, 34, 0.5);">Mostrando 12 de 24 productos</span>
                        <select class="sort-select">
                            <option>Ordenar por: Destacados</option>
                            <option>Precio: Menor a Mayor</option>
                            <option>Precio: Mayor a Menor</option>
                        </select>
                    </div>

                    <div class="product-grid">
                        @php
                            $products = [
                                ['id' => 2, 'name' => 'Aceite de Eucalipto', 'price' => '18.90€', 'img' => asset('img/imgPrueba.png'), 'cat' => 'Aceites'],
                                ['id' => 3, 'name' => 'Jabón de Caléndula', 'price' => '8.00€', 'img' => asset('img/imgPrueba.png'), 'cat' => 'Cosmética'],
                                ['id' => 4, 'name' => 'Bálsamo de Karité', 'price' => '15.75€', 'img' => asset('img/imgPrueba.png'), 'cat' => 'Cosmética'],
                                ['id' => 5, 'name' => 'Aceite de Menta', 'price' => '14.20€', 'img' => asset('img/imgPrueba.png'), 'cat' => 'Aceites'],
                                ['id' => 6, 'name' => 'Té Verde Orgánico', 'price' => '10.50€', 'img' => asset('img/imgPrueba.png'), 'cat' => 'Infusiones'],
                                ['id' => 7, 'name' => 'Bruma de Rosas', 'price' => '22.00€', 'img' => asset('img/imgPrueba.png'), 'cat' => 'Cosmética'],
                                ['id' => 8, 'name' => 'Sales de Epson', 'price' => '9.90€', 'img' => asset('img/imgPrueba.png'), 'cat' => 'Baño'],
                                ['id' => 9, 'name' => 'Vela de Soja', 'price' => '16.50€', 'img' => asset('img/imgPrueba.png'), 'cat' => 'Hogar'],
                                ['id' => 10, 'name' => 'Crema Facial Algas', 'price' => '28.00€', 'img' => asset('img/imgPrueba.png'), 'cat' => 'Cosmética'],
                                ['id' => 11, 'name' => 'Tónico Facial', 'price' => '14.75€', 'img' => asset('img/imgPrueba.png'), 'cat' => 'Cosmética'],
                                ['id' => 12, 'name' => 'Infusión Energizante', 'price' => '11.20€', 'img' => asset('img/imgPrueba.png'), 'cat' => 'Infusiones'],
                            ];
                        @endphp




                        @foreach($products as $product)
                        <div class="product-card" style="position: relative;">
                            <a href="/producto/{{ $product['id'] }}">
                                <div class="product-img">
                                    <img src="{{ $product['img'] }}" alt="{{ $product['name'] }}" style="transition: transform 0.5s;">
                                    <div class="product-overlay" style="position: absolute; inset: 0; background: rgba(27, 48, 34, 0.05); opacity: 0; transition: opacity 0.3s; display: flex; align-items: center; justify-content: center;">
                                        <span style="background: white; color: var(--brand-green); padding: 0.5rem 1rem; border-radius: 9999px; font-size: 0.75rem; font-weight: bold;">VER DETALLE</span>
                                    </div>
                                </div>
                            </a>
                            <div class="product-details">
                                <span style="font-size: 10px; font-weight: bold; color: rgba(27, 48, 34, 0.4); text-transform: uppercase; letter-spacing: 0.2em; display: block; margin-bottom: 0.5rem;">{{ $product['cat'] }}</span>
                                <h4 style="font-weight: bold; font-size: 1.125rem; margin-bottom: 1rem; min-height: 2.8rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    <a href="/producto/{{ $product['id'] }}">{{ $product['name'] }}</a>
                                </h4>
                                <div style="display: flex; align-items: center; justify-content: space-between;">
                                    <span style="font-size: 1.25rem; font-weight: 300;">{{ $product['price'] }}</span>
                                    <button class="btn-primary" style="padding: 0.5rem 1rem; font-size: 0.75rem; border-radius: 0.5rem;">
                                        Añadir
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>

                    <!-- Pagination -->
                    <div class="text-center mt-6 flex justify-center gap-4">
                        <button style="width: 2.5rem; height: 2.5rem; border: 1px solid rgba(27, 48, 34, 0.1); border-radius: 50%; background: white; color: var(--brand-green); font-weight: bold;">1</button>
                        <button style="width: 2.5rem; height: 2.5rem; border: 1px solid transparent; border-radius: 50%; color: rgba(27, 48, 34, 0.5);">2</button>
                        <button style="width: 2.5rem; height: 2.5rem; border: 1px solid transparent; border-radius: 50%; color: rgba(27, 48, 34, 0.5);">3</button>
                    </div>
                </main>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/jsCatalog.js') }}"></script>
@endpush
