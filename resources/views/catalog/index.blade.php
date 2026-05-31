@extends('landingPage')

@push('style')
    <link rel="stylesheet" href="{{ asset('css/styleCatalog.css') }}">
@endpush

@section('main_content')
    <div class="section-padding" style="background: var(--brand-cream); min-height: 100vh;">
        <div class="container">
            <!-- Breadcrumbs -->
            <div class="mb-8" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em; color: rgba(27, 48, 34, 0.4);">
                <a href="{{ url('/') }}">Inicio</a> / <span style="color: var(--brand-green); font-weight: 500;">Catálogo</span>
            </div>

            <h1 class="section-title">Todos los Productos</h1>

            @if(session('success'))
                <div class="alert alert-success mb-4" style="background: rgba(76, 175, 80, 0.12); color: var(--brand-green); padding: 0.75rem 1rem; border-radius: 0.5rem; font-family: var(--fuente-sans);">
                    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                </div>
            @endif

            <div class="catalog-layout">
                <!-- Filtros en su propio form (no envolver los formularios de "Añadir al carrito") -->
                <aside class="filters-sidebar">
                    <form id="filterForm" method="GET" action="{{ route('catalog.index') }}">
                        <input type="hidden" id="category_input" value="">
                        <a href="#" class="filter-link" style="display:none;"></a>

                        <div class="filter-group">
                            <span class="filter-title">Buscar Producto</span>
                            <input type="text" name="search" value="{{ request('search') }}" oninput="debouncedSubmitFilterForm(event)" placeholder="Ej. Aceite esencial..." style="margin-bottom: 0.75rem;">
                            <button type="button" onclick="resetCatalogFilters(event)" class="btn-reset-filters">
                                <i class="fa-solid fa-rotate-left"></i> Limpiar Filtros
                            </button>
                        </div>

                        <div class="filter-group">
                            <span class="filter-title">Categorías</span>
                            <ul class="filter-list">
                                @foreach($categories as $category)
                                <li>
                                    <label>
                                        <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                               {{ in_array($category->id, request('categories', [])) ? 'checked' : '' }}
                                               onchange="submitFilterForm(event)">
                                        <span class="custom-checkbox"></span>
                                        {{ $category->name }}
                                    </label>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="filter-group price-filter" data-min="0" data-max="200">
                            <span class="filter-title">Precio</span>
                            <div class="price-inputs">
                                <label>
                                    <span>Mínimo</span>
                                    <input id="price_min_input" type="number" name="min_price" min="0" max="200" step="0.01" value="{{ request('min_price', 0) }}">
                                </label>
                                <label>
                                    <span>Máximo</span>
                                    <input id="price_max_input" type="number" name="max_price" min="0" max="200" step="0.01" value="{{ request('max_price', 200) }}">
                                </label>
                            </div>
                            <div class="price-slider">
                                <div class="price-slider-track"></div>
                                <div id="price_slider_range" class="price-slider-range"></div>
                                <input id="price_min_range" type="range" min="0" max="200" step="0.01" value="{{ request('min_price', 0) }}">
                                <input id="price_max_range" type="range" min="0" max="200" step="0.01" value="{{ request('max_price', 200) }}">
                            </div>
                            <div class="price-limits">
                                <span>0&euro;</span>
                                <span>200&euro;</span>
                            </div>
                        </div>
                    </form>
                </aside>

                <main id="catalog-results">
                    @include('catalog.partials.results')
                </main>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/jsCatalog.js') }}"></script>
@endpush
