<div class="catalog-header">
    <span style="font-size: 0.875rem; color: rgba(27, 48, 34, 0.5);">Mostrando {{ $products->count() }} de {{ $products->total() }} productos</span>
    <select name="sort" class="sort-select" onchange="submitFilterForm(event)">
        <option value="">Ordenar por: Destacados</option>
        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Precio: Menor a Mayor</option>
        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Precio: Mayor a Menor</option>
    </select>
</div>

@if($products->isEmpty())
<div class="no-products-container" style="text-align: center; padding: 5rem 2rem; background: rgba(255, 255, 255, 0.6); border-radius: 1.5rem; border: 1px dashed rgba(27, 48, 34, 0.15); margin-top: 1rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);">
    <div style="font-size: 4.5rem; color: rgba(27, 48, 34, 0.18); margin-bottom: 1.5rem;">
        <i class="fa-solid fa-seedling"></i>
    </div>
    <h3 style="font-size: 1.5rem; font-weight: 700; color: var(--brand-green); margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">No encontramos lo que buscas</h3>
    <p style="font-size: 0.95rem; color: rgba(27, 48, 34, 0.6); max-width: 400px; margin: 0 auto 2.25rem; line-height: 1.6;">
        Prueba a buscar con otra palabra, ajusta los filtros de precio o explora otras categorías.
    </p>
    <button type="button" onclick="resetCatalogFilters(event)" class="btn-primary" style="display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none; padding: 0.75rem 2rem; font-size: 0.875rem; font-weight: bold; border-radius: 9999px; text-transform: uppercase; letter-spacing: 0.05em; transition: all 0.3s; background: var(--brand-green); color: white; border: none; cursor: pointer; box-shadow: 0 4px 15px rgba(27, 48, 34, 0.2);">
        <i class="fa-solid fa-rotate-left"></i> Restablecer Filtros
    </button>
</div>
@else
<div class="product-grid">
    @foreach($products as $product)
    <div class="product-card" style="position: relative;">
        <a href="{{ route('catalog.show', $product->id) }}">
            <div class="product-img">
                <img src="{{ asset('img/imgPrueba.png') }}" alt="{{ $product->name }}" style="transition: transform 0.5s;">
                <div class="product-overlay" style="position: absolute; inset: 0; background: rgba(27, 48, 34, 0.05); opacity: 0; transition: opacity 0.3s; display: flex; align-items: center; justify-content: center;">
                    <span style="background: white; color: var(--brand-green); padding: 0.5rem 1rem; border-radius: 9999px; font-size: 0.75rem; font-weight: bold;">VER DETALLE</span>
                </div>
            </div>
        </a>
        <div class="product-details">
            <span style="font-size: 10px; font-weight: bold; color: rgba(27, 48, 34, 0.4); text-transform: uppercase; letter-spacing: 0.2em; display: block; margin-bottom: 0.5rem;">{{ $product->categories->first()->name ?? 'Sin categoría' }}</span>
            <h4 style="font-weight: bold; font-size: 1.125rem; margin-bottom: 1rem; min-height: 2.8rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                <a href="{{ route('catalog.show', $product->id) }}">{{ $product->name }}</a>
            </h4>
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <span style="font-size: 1.25rem; font-weight: 300;">{{ number_format($product->price, 2) }}€</span>
                <button class="btn-primary" style="padding: 0.5rem 1rem; font-size: 0.75rem; border-radius: 0.5rem;">
                    Añadir
                </button>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Pagination -->
<div class="mt-6 flex justify-center pagination-container">
    {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
</div>
@endif
