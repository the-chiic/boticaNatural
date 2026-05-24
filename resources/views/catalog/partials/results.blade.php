<div class="catalog-header">
    <span class="results-count" style="font-size: 0.85rem; color: rgba(27, 48, 34, 0.6); font-family: var(--fuente-sans);">
        Mostrando <strong>{{ $products->count() }}</strong> de <strong>{{ $products->total() }}</strong> productos
    </span>
    <select name="sort" class="sort-select" onchange="submitFilterForm(event)">
        <option value="">Ordenar por: Destacados</option>
        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Precio: Menor a Mayor</option>
        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Precio: Mayor a Menor</option>
    </select>
</div>

@if($products->isEmpty())
<div class="no-products-container" style="text-align: center; padding: 5rem 2rem; background: rgba(255, 255, 255, 0.45); border-radius: 1.5rem; border: 1px dashed rgba(27, 48, 34, 0.12); margin-top: 1rem; box-shadow: var(--sombra-suave);">
    <div style="font-size: 3.5rem; color: var(--brand-accent); opacity: 0.7; margin-bottom: 1.25rem;">
        <i class="fa-solid fa-leaf"></i>
    </div>
    <h3 style="font-family: var(--fuente-serif); font-size: 1.5rem; font-weight: 500; color: var(--brand-green); margin-bottom: 0.75rem;">No hemos encontrado productos</h3>
    <p style="font-size: 0.875rem; color: rgba(27, 48, 34, 0.6); max-width: 360px; margin: 0 auto 2rem; line-height: 1.6;">
        Intenta cambiar los términos de búsqueda, ajustar los filtros de precio o explorar otras categorías de nuestra botica.
    </p>
    <button type="button" onclick="resetCatalogFilters(event)" class="btn-reset-filters" style="display: inline-flex; width: auto; max-width: 220px; margin: 0 auto; justify-content: center;">
        <i class="fa-solid fa-rotate-left"></i> Restablecer Filtros
    </button>
</div>
@else
<div class="product-grid">
    @foreach($products as $product)
    <div class="product-card">
        <a href="{{ route('catalog.show', $product->id) }}">
            <div class="product-img">
                <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('img/imgPrueba.png') }}" alt="{{ $product->name }}">
                <div class="product-overlay">
                    <span>Ver Detalle</span>
                </div>
            </div>
        </a>
        <div class="product-details">
            <span style="font-size: 10px; font-weight: 600; color: rgba(27, 48, 34, 0.45); text-transform: uppercase; letter-spacing: 0.15em; display: block; margin-bottom: 0.40rem; font-family: var(--fuente-sans);">
                {{ $product->categories->first()->name ?? 'Sin categoría' }}
            </span>
            <h4>
                <a href="{{ route('catalog.show', $product->id) }}">{{ $product->name }}</a>
            </h4>
            <div style="display: flex; align-items: center; justify-content: space-between; margin-top: auto;">
                <span class="price-label">{{ number_format($product->price, 2) }}€</span>
                <form action="{{ route('cart.add', $product->id) }}" method="POST" style="margin: 0; padding: 0; border: none; background: transparent; display: inline-flex; align-items: center;">
                    @csrf
                    <input type="hidden" name="qty" value="1">
                    <button type="submit" class="btn-primary">
                        Añadir
                    </button>
                </form>
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
