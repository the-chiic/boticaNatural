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

            <form id="filterForm" method="GET" action="{{ route('catalog.index') }}">
                <!-- Dummy inputs to prevent old cached jsCatalog.js from crashing -->
                <input type="hidden" id="category_input" value="">
                <a href="#" class="filter-link" style="display:none;"></a>

            <div class="catalog-layout">
                <!-- Filters -->
                <aside class="filters-sidebar">
                    <div class="filter-group">
                        <span class="filter-title">Buscar Producto</span>
                        <input type="text" name="search" value="{{ request('search') }}" oninput="submitFilterForm(event)" placeholder="Ej. Aceite esencial..." style="width: 100%; padding: 0.5rem 1rem; border: 1px solid rgba(27, 48, 34, 0.2); border-radius: 0.5rem; outline: none; font-size: 0.875rem; color: var(--brand-green); margin-bottom: 0.75rem;">
                        <button type="button" onclick="resetCatalogFilters(event)" class="btn-reset-filters" 
                                style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 0.55rem 1rem; font-size: 0.75rem; font-weight: bold; border-radius: 0.5rem; background: transparent; border: 1px solid rgba(27, 48, 34, 0.2); color: rgba(27, 48, 34, 0.7); cursor: pointer; transition: all 0.2s; text-transform: uppercase; letter-spacing: 0.05em;"
                                onmouseover="this.style.backgroundColor='rgba(27, 48, 34, 0.05)'; this.style.borderColor='var(--brand-green)'; this.style.color='var(--brand-green)';"
                                onmouseout="this.style.backgroundColor='transparent'; this.style.borderColor='rgba(27, 48, 34, 0.2)'; this.style.color='rgba(27, 48, 34, 0.7)';"
                        >
                            <i class="fa-solid fa-rotate-left"></i> Limpiar Filtros
                        </button>
                    </div>
                    <div class="filter-group">
                        <span class="filter-title">Categorías</span>
                        <ul class="filter-list">
                            @foreach($categories as $category)
                            <li>
                                <label class="flex items-center gap-2" style="font-size: 0.875rem; color: rgba(27, 48, 34, 0.6); cursor: pointer;">
                                    <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                           {{ in_array($category->id, request('categories', [])) ? 'checked' : '' }}
                                           onchange="submitFilterForm(event)"
                                           style="accent-color: var(--brand-green);">
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
                                <span>M&iacute;nimo</span>
                                <input id="price_min_input" type="number" name="min_price" min="0" max="200" step="0.01" value="{{ request('min_price', 0) }}">
                            </label>
                            <label>
                                <span>M&aacute;ximo</span>
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

                </aside>

                <!-- Products -->
                <main id="catalog-results">
                    @include('catalog.partials.results')
                </main>
            </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/jsCatalog.js') }}"></script>
@endpush
