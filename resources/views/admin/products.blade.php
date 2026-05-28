<x-admin.layout title="Productos" subtitle="Catálogo completo de productos.">

    @if(session('success'))
        <div class="alert-success">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    <div class="panel">
        <div class="panel-header">
            <h3>Todos los Productos</h3>
            <button class="btn btn-sm" onclick="openAddModal()">
                <i class="fa-solid fa-plus btn-icon"></i> Añadir Producto
            </button>
        </div>

        <!-- Barra de Filtros SPA -->
        <div class="filter-bar-container" style="display: flex; gap: 15px; margin-bottom: 20px; padding: 15px; background-color: var(--cream); border: 1px solid var(--beige); border-radius: 10px;">
            <div style="flex: 2; position: relative;">
                <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--sage-green);"></i>
                <input type="text" id="spaSearchInput" placeholder="Buscar producto por nombre..." style="width: 100%; padding: 10px 15px 10px 42px; border: 1px solid var(--beige); border-radius: 20px; outline: none; font-size: 14px; background-color: var(--white); transition: border-color 0.2s;" onkeyup="filterProductsTable()">
            </div>
            <div style="flex: 1;">
                <select id="spaCategorySelect" style="width: 100%; padding: 10px 15px; border: 1px solid var(--beige); border-radius: 20px; outline: none; font-size: 14px; background-color: var(--white); cursor: pointer;" onchange="filterProductsTable()">
                    <option value="">Todas las Categorías</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->name }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Stock</th>
                    <th>Precio</th>
                    <th>Estado</th>
                    <th style="text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @php 
                    $colors = ['bg-olive', 'bg-brown', 'bg-sage', 'bg-dark']; 
                @endphp
                @forelse($products as $product)
                    <tr class="product-row" data-name="{{ strtolower($product->name) }}" data-category="{{ $product->categories->first()->name ?? '' }}">
                        <td>
                            <div class="thumb" style="overflow: hidden; display: flex; align-items: center; justify-content: center; background-color: var(--beige);">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.onerror=null; this.parentElement.innerText='{{ strtoupper(substr($product->name, 0, 1)) }}';">
                            </div>
                        </td>
                        <td style="font-weight: 600; color: var(--dark-green);">{{ $product->name }}</td>
                        <td>{{ $product->categories->first()->name ?? 'Sin Categoría' }}</td>
                        <td>
                            @if($product->stock <= 5)
                                <span style="color: var(--brown); font-weight: 700;">{{ $product->stock }} (Crítico)</span>
                            @else
                                {{ $product->stock }}
                            @endif
                        </td>
                        <td style="font-weight: 600;">€{{ number_format($product->price, 2) }}</td>
                        <td>
                            @if($product->status == 1)
                                <span class="badge badge-success">Activo</span>
                            @else
                                <span class="badge badge-danger">Inactivo</span>
                            @endif
                        </td>
                        <td style="text-align: right;">
                            @php
                                $rawGallery = [];
                                if (!empty($product->getRawOriginal('gallery_images'))) {
                                    $rawGallery = json_decode($product->getRawOriginal('gallery_images'), true) ?: [];
                                }
                                $resolvedGallery = array_map(function($img) {
                                    if (str_starts_with($img, 'http://') || str_starts_with($img, 'https://')) {
                                        return $img;
                                    }
                                    return asset($img);
                                }, $rawGallery);
                            @endphp
                            <button class="btn-icon-link edit" title="Editar" 
                                onclick="openEditModal(JSON.parse(this.getAttribute('data-product')))"
                                data-product="{{ json_encode([
                                    'id' => $product->id,
                                    'name' => $product->name,
                                    'description' => $product->description,
                                    'price' => $product->price,
                                    'stock' => $product->stock,
                                    'status' => $product->status,
                                    'category_id' => $product->categories->first()->id ?? '',
                                    'image_url' => $product->getRawOriginal('image_url') ?? '',
                                    'display_image' => $product->image_url,
                                    'gallery' => $rawGallery,
                                    'resolved_gallery' => $resolvedGallery
                                ]) }}">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <form action="{{ route('admin.productos.delete', $product->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este producto permanentemente?')">
                                @csrf
                                <button type="submit" class="btn-icon-link delete" title="Eliminar">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: #888;">No hay productos en el catálogo.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        @if($products->hasPages())
            <div class="pagination-container">
                @if ($products->onFirstPage())
                    <span>&laquo;</span>
                @else
                    <a href="{{ $products->previousPageUrl() }}">&laquo;</a>
                @endif

                @foreach ($products->getUrlRange(max(1, $products->currentPage() - 2), min($products->lastPage(), $products->currentPage() + 2)) as $page => $url)
                    @if ($page == $products->currentPage())
                        <span class="active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach

                @if ($products->hasMorePages())
                    <a href="{{ $products->nextPageUrl() }}">&raquo;</a>
                @else
                    <span>&raquo;</span>
                @endif
            </div>
        @endif
    </div>

    <!-- Modal Box -->
    <div id="productModal" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-header">
                <h3 id="modalTitle">Nuevo Producto</h3>
                <button class="modal-close" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body">
                <form id="productForm" action="{{ route('admin.productos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="product_id" name="id">
                    
                    <div class="form-group">
                        <label for="name">Nombre del Producto</label>
                        <input type="text" id="name" name="name" required placeholder="Ej. Crema Facial de Rosa Mosqueta">
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Descripción (Máximo 200 caracteres)</label>
                        <textarea id="description" name="description" rows="2" maxlength="200" placeholder="Breve explicación de las propiedades del producto..."></textarea>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="price">Precio (€)</label>
                            <input type="number" id="price" name="price" step="0.01" min="0" required placeholder="0.00">
                        </div>
                        <div class="form-group">
                            <label for="stock">Stock Disponible</label>
                            <input type="number" id="stock" name="stock" min="0" required placeholder="0">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="category_id">Categoría Principal</label>
                            <select id="category_id" name="category_id" required>
                                <option value="" disabled selected>Selecciona una categoría</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status">Estado del Catálogo</label>
                            <select id="status" name="status" required>
                                <option value="1" selected>Activo (Visible en tienda)</option>
                                <option value="0">Inactivo (Oculto)</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row" style="margin-top: 10px;">
                        <div class="form-group" style="flex: 2;">
                            <label for="image_file">Subir Imagen del Producto (Local)</label>
                            <input type="file" id="image_file" name="image_file" accept="image/*" onchange="previewImage(this, 'product_img_preview')">
                        </div>
                        <div class="form-group" style="flex: 1; display: flex; align-items: flex-end; justify-content: center;">
                            <div style="width: 80px; height: 80px; border: 1px solid var(--beige); border-radius: 8px; overflow: hidden; background-color: var(--white); display: flex; align-items: center; justify-content: center;">
                                <img id="product_img_preview" src="{{ asset('img/imgPrueba.png') }}" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group" style="margin-top: 10px;">
                        <label for="image_url">O pegar URL de Imagen Externa</label>
                        <input type="text" id="image_url" name="image_url" placeholder="https://ejemplo.com/imagen.jpg" oninput="previewImageUrl(this.value, 'product_img_preview')">
                    </div>

                    <!-- Galería de imágenes adicionales -->
                    <div class="form-group" style="margin-top: 20px; border-top: 1px solid var(--beige); padding-top: 15px;">
                        <label style="font-weight: 700; color: var(--dark-green); display: block; margin-bottom: 10px;">
                            Galería de Imágenes Adicionales
                        </label>
                        
                        <!-- Contenedor para imágenes de la galería existentes -->
                        <div id="existing_gallery_container" style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 15px;">
                            <!-- Cargadas por Javascript en modo Edición -->
                        </div>
                        
                        <!-- Inputs para añadir más imágenes -->
                        <div class="form-group">
                            <label for="gallery_files">Subir Múltiples Imágenes (Local)</label>
                            <input type="file" id="gallery_files" name="gallery_files[]" multiple accept="image/*">
                        </div>
                        
                        <div class="form-group" style="margin-top: 15px;">
                            <label>Pegar URLs de Imágenes Externas Adicionales</label>
                            <div id="gallery_urls_container" style="display: flex; flex-direction: column; gap: 8px;">
                                <!-- Inputs dinámicos para URLs de galería -->
                            </div>
                            <button type="button" class="btn btn-sm" style="background-color: var(--sage-green); margin-top: 8px; padding: 6px 12px; font-size: 12px;" onclick="addGalleryUrlField()">
                                <i class="fa-solid fa-plus btn-icon"></i> Añadir URL de Galería
                            </button>
                        </div>
                    </div>
                    
                    <div class="form-actions" style="margin-top: 15px;">
                        <button type="button" class="btn" style="background-color: var(--sage-green); margin-right: 10px;" onclick="closeModal()">Cancelar</button>
                        <button type="submit" class="btn">Guardar Producto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const modal = document.getElementById('productModal');
        const form = document.getElementById('productForm');
        const modalTitle = document.getElementById('modalTitle');
        const storeUrl = "{{ route('admin.productos.store') }}";

        function openAddModal() {
            modalTitle.innerText = "Nuevo Producto";
            form.action = storeUrl;
            form.reset();
            document.getElementById('product_id').value = "";
            document.getElementById('product_img_preview').src = "{{ asset('img/imgPrueba.png') }}";
            
            document.getElementById('existing_gallery_container').innerHTML = '';
            document.getElementById('gallery_urls_container').innerHTML = '';
            
            modal.style.display = "flex";
            setTimeout(() => modal.classList.add('active'), 10);
        }

        function openEditModal(product) {
            modalTitle.innerText = "Editar Producto";
            form.action = `/admin/productos/${product.id}`;
            form.reset();
            
            document.getElementById('product_id').value = product.id;
            document.getElementById('name').value = product.name;
            document.getElementById('description').value = product.description;
            document.getElementById('price').value = product.price;
            document.getElementById('stock').value = product.stock;
            document.getElementById('category_id').value = product.category_id;
            document.getElementById('status').value = product.status;
            document.getElementById('image_url').value = product.image_url || '';
            document.getElementById('product_img_preview').src = product.display_image || "{{ asset('img/imgPrueba.png') }}";
            
            // Cargar imágenes de la galería existentes
            const existingContainer = document.getElementById('existing_gallery_container');
            const urlsContainer = document.getElementById('gallery_urls_container');
            existingContainer.innerHTML = '';
            urlsContainer.innerHTML = '';
            
            if (product.gallery && product.gallery.length > 0) {
                product.gallery.forEach((rawImg, index) => {
                    const resolvedImg = product.resolved_gallery[index];
                    
                    const itemDiv = document.createElement('div');
                    itemDiv.style.position = 'relative';
                    itemDiv.style.width = '70px';
                    itemDiv.style.height = '70px';
                    itemDiv.style.borderRadius = '6px';
                    itemDiv.style.overflow = 'hidden';
                    itemDiv.style.border = '1px solid var(--beige)';
                    
                    itemDiv.innerHTML = `
                        <img src="${resolvedImg}" style="width:100%; height:100%; object-fit:cover;">
                        <input type="hidden" name="existing_gallery[]" value="${rawImg}">
                        <button type="button" onclick="this.parentElement.remove()" style="position:absolute; top:2px; right:2px; background:rgba(239, 68, 68, 0.85); color:#fff; border:none; width:18px; height:18px; border-radius:50%; display:flex; align-items:center; justify-content:center; cursor:pointer; font-size:10px; font-weight:bold; padding:0; line-height:1;" title="Eliminar">×</button>
                    `;
                    existingContainer.appendChild(itemDiv);
                });
            }
            
            modal.style.display = "flex";
            setTimeout(() => modal.classList.add('active'), 10);
        }

        function addGalleryUrlField() {
            const container = document.getElementById('gallery_urls_container');
            const fieldId = 'gurl_' + Date.now() + '_' + Math.random().toString(36).substr(2, 5);
            
            const rowDiv = document.createElement('div');
            rowDiv.id = fieldId;
            rowDiv.style.display = 'flex';
            rowDiv.style.gap = '8px';
            rowDiv.style.marginTop = '6px';
            
            rowDiv.innerHTML = `
                <input type="text" name="gallery_urls[]" placeholder="https://ejemplo.com/imagen-adicional.jpg" style="flex:1; padding:8px 12px; border:1px solid var(--beige); border-radius:6px; outline:none; font-size:13px;">
                <button type="button" class="btn" style="background-color:#ef4444; color:#fff; padding:6px 12px; border-radius:6px; border:none; cursor:pointer;" onclick="document.getElementById('${fieldId}').remove()"><i class="fa-solid fa-trash-can"></i></button>
            `;
            container.appendChild(rowDiv);
        }

        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewImageUrl(url, previewId) {
            const preview = document.getElementById(previewId);
            if (url && (url.startsWith('http://') || url.startsWith('https://') || url.startsWith('/img/') || url.startsWith('img/'))) {
                preview.src = url;
            } else {
                preview.src = "{{ asset('img/imgPrueba.png') }}";
            }
        }

        function closeModal() {
            modal.classList.remove('active');
            setTimeout(() => modal.style.display = "none", 300);
        }

        function filterProductsTable() {
            const searchQuery = document.getElementById('spaSearchInput').value.toLowerCase().trim();
            const selectedCategory = document.getElementById('spaCategorySelect').value.toLowerCase().trim();
            const rows = document.querySelectorAll('.product-row');
            
            rows.forEach(row => {
                const name = row.getAttribute('data-name');
                const category = row.getAttribute('data-category').toLowerCase().trim();
                
                const matchesSearch = name.includes(searchQuery);
                const matchesCategory = !selectedCategory || category === selectedCategory;
                
                if (matchesSearch && matchesCategory) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
    @endpush
</x-admin.layout>
