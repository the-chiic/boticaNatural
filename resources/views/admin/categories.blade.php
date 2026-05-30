<x-admin.layout title="Categorías" subtitle="Clasificación botánica y de cosmética del catálogo.">

    @if(session('success'))
        <div class="alert-success">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    <div class="panel">
        <div class="panel-header">
            <h3>Categorías de la Tienda</h3>
            <button class="btn btn-sm" onclick="openAddModal()">
                <i class="fa-solid fa-plus btn-icon"></i> Añadir Categoría
            </button>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Icono</th>
                    <th>Nombre de Categoría</th>
                    <th>Descripción</th>
                    <th style="text-align: center;">Productos Vinculados</th>
                    <th style="text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @php 
                    $colors = ['bg-olive', 'bg-brown', 'bg-sage', 'bg-dark']; 
                @endphp
                @forelse($categories as $category)
                    @php
                        $catBgUrl = 'https://images.unsplash.com/photo-1465146344425-f00d5f5c8f07?q=80&w=800&auto=format&fit=crop';
                        if (!empty($category->img)) {
                            if (str_starts_with($category->img, 'http://') || str_starts_with($category->img, 'https://')) {
                                $catBgUrl = $category->img;
                            } elseif (file_exists(public_path($category->img))) {
                                $catBgUrl = asset($category->img);
                            } elseif (file_exists(public_path('img/' . $category->img))) {
                                $catBgUrl = asset('img/' . $category->img);
                            } elseif (file_exists(public_path('storage/' . $category->img))) {
                                $catBgUrl = asset('storage/' . $category->img);
                            }
                        } else {
                            $nameLower = mb_strtolower($category->name);
                            if (str_contains($nameLower, 'infusion') || str_contains($nameLower, 'té') || str_contains($nameLower, 'te')) {
                                $catBgUrl = 'https://images.unsplash.com/photo-1576092762791-dd9e2220d960?q=80&w=800&auto=format&fit=crop';
                            } elseif (str_contains($nameLower, 'aceite')) {
                                $catBgUrl = 'https://images.unsplash.com/photo-1608248543803-ba4f8c70ae0b?q=80&w=800&auto=format&fit=crop';
                            } elseif (str_contains($nameLower, 'cosmet') || str_contains($nameLower, 'cosmét')) {
                                $catBgUrl = 'https://images.unsplash.com/photo-1556228573-7303e8707198?q=80&w=800&auto=format&fit=crop';
                            } elseif (str_contains($nameLower, 'medic')) {
                                $catBgUrl = 'https://images.unsplash.com/photo-1471864190281-a93a3070b6de?q=80&w=800&auto=format&fit=crop';
                            } elseif (str_contains($nameLower, 'herbol') || str_contains($nameLower, 'plant') || str_contains($nameLower, 'natural')) {
                                $catBgUrl = 'https://images.unsplash.com/photo-1515694346937-94d85e41e6f0?q=80&w=800&auto=format&fit=crop';
                            }
                        }
                    @endphp
                    <tr>
                        <td>
                            <div class="thumb" style="overflow: hidden; display: flex; align-items: center; justify-content: center; background-color: var(--beige);">
                                <img src="{{ $catBgUrl }}" alt="{{ $category->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                        </td>
                        <td style="font-weight: 600; color: var(--dark-green);">{{ $category->name }}</td>
                        <td>{{ $category->description ?? 'Sin descripción disponible' }}</td>
                        <td style="text-align: center;">
                            <span class="badge badge-success" style="font-size: 12px; padding: 6px 12px; border-radius: 20px;">
                                {{ $category->products_count }} {{ $category->products_count === 1 ? 'Producto' : 'Productos' }}
                            </span>
                        </td>
                        <td style="text-align: right;">
                            <button class="btn-icon-link edit" title="Editar" 
                                onclick="openEditModal(JSON.parse(this.getAttribute('data-category')))"
                                data-category="{{ json_encode([
                                    'id' => $category->id,
                                    'name' => $category->name,
                                    'description' => $category->description,
                                    'img' => $category->img ?? '',
                                    'display_image' => $catBgUrl
                                ]) }}">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <form action="{{ route('admin.categorias.delete', $category->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta categoría permanentemente? Se desvinculará de todos los productos.')">
                                @csrf
                                <button type="submit" class="btn-icon-link delete" title="Eliminar">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: #888;">No hay categorías registradas en el catálogo.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($categories->lastPage() > 1)
        @php
            $paginator = $categories->withPath(url()->current())->appends(request()->query());
            $currentPage = $paginator->currentPage();
            $lastPage = $paginator->lastPage();
            $start = max($currentPage - 2, 1);
            $end = min($currentPage + 2, $lastPage);
        @endphp
        <div class="mt-6 flex justify-center pagination-container" style="display: flex; justify-content: center; align-items: center; gap: 0.5rem; width: 100%; margin-top: 2rem;">

            {{-- Double Left Arrow: Jumps to First Page (Page 1) --}}
            @if($paginator->onFirstPage())
                <span class="pagination-btn disabled" style="opacity: 0.5; cursor: not-allowed; border: 1px solid rgba(27,48,34,0.08); border-radius: 9999px; display: inline-flex; align-items: center; justify-content: center; background: white; color: #777; width: 2.4rem; height: 2.4rem; font-size: 0.8rem;">
                    <i class="fa-solid fa-angles-left"></i>
                </span>
            @else
                <a href="{{ $paginator->url(1) }}" class="pagination-btn" style="border: 1px solid rgba(27,48,34,0.08); border-radius: 9999px; display: inline-flex; align-items: center; justify-content: center; background: white; color: var(--brand-green, #1E3A2E); text-decoration: none; transition: all 0.2s; width: 2.4rem; height: 2.4rem; font-size: 0.8rem;" onmouseover="this.style.background='var(--brand-cream, #FAF9F6)'" onmouseout="this.style.background='white'">
                    <i class="fa-solid fa-angles-left"></i>
                </a>
            @endif

            {{-- Single Left Arrow: Jumps to Previous Page --}}
            @if($paginator->onFirstPage())
                <span class="pagination-btn disabled" style="opacity: 0.5; cursor: not-allowed; border: 1px solid rgba(27,48,34,0.08); border-radius: 9999px; display: inline-flex; align-items: center; justify-content: center; background: white; color: #777; width: 2.4rem; height: 2.4rem; font-size: 0.8rem;">
                    <i class="fa-solid fa-angle-left"></i>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="pagination-btn" style="border: 1px solid rgba(27,48,34,0.08); border-radius: 9999px; display: inline-flex; align-items: center; justify-content: center; background: white; color: var(--brand-green, #1E3A2E); text-decoration: none; transition: all 0.2s; width: 2.4rem; height: 2.4rem; font-size: 0.8rem;" onmouseover="this.style.background='var(--brand-cream, #FAF9F6)'" onmouseout="this.style.background='white'">
                    <i class="fa-solid fa-angle-left"></i>
                </a>
            @endif

            {{-- Page Numbers (Truncated with Ellipsis) --}}
            @if($start > 1)
                <a href="{{ $paginator->url(1) }}" class="pagination-btn" style="border: 1px solid rgba(27,48,34,0.08); border-radius: 9999px; display: inline-flex; align-items: center; justify-content: center; background: white; color: var(--brand-green, #1E3A2E); text-decoration: none; font-weight: 600; width: 2.4rem; height: 2.4rem; font-size: 0.8rem;" onmouseover="this.style.background='var(--brand-cream, #FAF9F6)'" onmouseout="this.style.background='white'">1</a>
                @if($start > 2)
                    <span style="color: rgba(27,48,34,0.5); padding: 0 0.25rem;">...</span>
                @endif
            @endif

            @for($i = $start; $i <= $end; $i++)
                @if($i == $currentPage)
                    <span class="pagination-btn active" style="background: var(--brand-green, #1E3A2E); color: white; border: 1px solid var(--brand-green, #1E3A2E); border-radius: 9999px; font-weight: 700; display: inline-flex; align-items: center; justify-content: center; width: 2.4rem; height: 2.4rem; font-size: 0.8rem; box-shadow: 0 4px 10px rgba(30, 58, 46, 0.15);">
                        {{ $i }}
                    </span>
                @else
                    <a href="{{ $paginator->url($i) }}" class="pagination-btn" style="border: 1px solid rgba(27,48,34,0.08); border-radius: 9999px; display: inline-flex; align-items: center; justify-content: center; background: white; color: var(--brand-green, #1E3A2E); text-decoration: none; font-weight: 600; transition: all 0.2s; width: 2.4rem; height: 2.4rem; font-size: 0.8rem;" onmouseover="this.style.background='var(--brand-cream, #FAF9F6)'" onmouseout="this.style.background='white'">
                        {{ $i }}
                    </a>
                @endif
            @endfor

            @if($end < $lastPage)
                @if($end < $lastPage - 1)
                    <span style="color: rgba(27,48,34,0.5); padding: 0 0.25rem;">...</span>
                @endif
                <a href="{{ $paginator->url($lastPage) }}" class="pagination-btn" style="border: 1px solid rgba(27,48,34,0.08); border-radius: 9999px; display: inline-flex; align-items: center; justify-content: center; background: white; color: var(--brand-green, #1E3A2E); text-decoration: none; font-weight: 600; width: 2.4rem; height: 2.4rem; font-size: 0.8rem;" onmouseover="this.style.background='var(--brand-cream, #FAF9F6)'" onmouseout="this.style.background='white'">{{ $lastPage }}</a>
            @endif

            {{-- Single Right Arrow: Jumps to Next Page --}}
            @if($paginator->currentPage() == $paginator->lastPage())
                <span class="pagination-btn disabled" style="opacity: 0.5; cursor: not-allowed; border: 1px solid rgba(27,48,34,0.08); border-radius: 9999px; display: inline-flex; align-items: center; justify-content: center; background: white; color: #777; width: 2.4rem; height: 2.4rem; font-size: 0.8rem;">
                    <i class="fa-solid fa-angle-right"></i>
                </span>
            @else
                <a href="{{ $paginator->nextPageUrl() }}" class="pagination-btn" style="border: 1px solid rgba(27,48,34,0.08); border-radius: 9999px; display: inline-flex; align-items: center; justify-content: center; background: white; color: var(--brand-green, #1E3A2E); text-decoration: none; transition: all 0.2s; width: 2.4rem; height: 2.4rem; font-size: 0.8rem;" onmouseover="this.style.background='var(--brand-cream, #FAF9F6)'" onmouseout="this.style.background='white'">
                    <i class="fa-solid fa-angle-right"></i>
                </a>
            @endif

            {{-- Double Right Arrow: Jumps to Last Page --}}
            @if($paginator->currentPage() == $paginator->lastPage())
                <span class="pagination-btn disabled" style="opacity: 0.5; cursor: not-allowed; border: 1px solid rgba(27,48,34,0.08); border-radius: 9999px; display: inline-flex; align-items: center; justify-content: center; background: white; color: #777; width: 2.4rem; height: 2.4rem; font-size: 0.8rem;">
                    <i class="fa-solid fa-angles-right"></i>
                </span>
            @else
                <a href="{{ $paginator->url($paginator->lastPage()) }}" class="pagination-btn" style="border: 1px solid rgba(27,48,34,0.08); border-radius: 9999px; display: inline-flex; align-items: center; justify-content: center; background: white; color: var(--brand-green, #1E3A2E); text-decoration: none; transition: all 0.2s; width: 2.4rem; height: 2.4rem; font-size: 0.8rem;" onmouseover="this.style.background='var(--brand-cream, #FAF9F6)'" onmouseout="this.style.background='white'">
                    <i class="fa-solid fa-angles-right"></i>
                </a>
            @endif

        </div>
        @endif
    </div>

    <!-- Modal Box -->
    <div id="categoryModal" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-header">
                <h3 id="modalTitle">Nueva Categoría</h3>
                <button class="modal-close" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body">
                <form id="categoryForm" action="{{ route('admin.categorias.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="category_id" name="id">
                    
                    <div class="form-group">
                        <label for="name">Nombre de la Categoría</label>
                        <input type="text" id="name" name="name" required placeholder="Ej. Aromaterapia">
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Descripción (Máximo 255 caracteres)</label>
                        <textarea id="description" name="description" rows="3" maxlength="255" placeholder="Explica las propiedades de los productos en esta categoría..."></textarea>
                    </div>

                    <div class="form-row" style="margin-top: 15px;">
                        <div class="form-group" style="flex: 2;">
                            <label for="img_file">Subir Imagen de la Categoría (Local)</label>
                            <input type="file" id="img_file" name="img_file" accept="image/*" onchange="previewImage(this, 'category_img_preview')">
                        </div>
                        <div class="form-group" style="flex: 1; display: flex; align-items: flex-end; justify-content: center;">
                            <div style="width: 80px; height: 80px; border: 1px solid var(--beige); border-radius: 8px; overflow: hidden; background-color: var(--white); display: flex; align-items: center; justify-content: center;">
                                <img id="category_img_preview" src="{{ asset('img/imgPrueba.png') }}" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group" style="margin-top: 10px;">
                        <label for="img_url">O pegar URL de Imagen Externa</label>
                        <input type="text" id="img_url" name="img_url" placeholder="https://ejemplo.com/imagen.jpg" oninput="previewImageUrl(this.value, 'category_img_preview')">
                    </div>
                    
                    <div class="form-actions" style="margin-top: 25px;">
                        <button type="button" class="btn" style="background-color: var(--sage-green); margin-right: 10px;" onclick="closeModal()">Cancelar</button>
                        <button type="submit" class="btn">Guardar Categoría</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const modal = document.getElementById('categoryModal');
        const form = document.getElementById('categoryForm');
        const modalTitle = document.getElementById('modalTitle');
        const storeUrl = "{{ route('admin.categorias.store') }}";

        function openAddModal() {
            modalTitle.innerText = "Nueva Categoría";
            form.action = storeUrl;
            form.reset();
            document.getElementById('category_id').value = "";
            document.getElementById('category_img_preview').src = "{{ asset('img/imgPrueba.png') }}";
            
            modal.style.display = "flex";
            setTimeout(() => modal.classList.add('active'), 10);
        }

        function openEditModal(category) {
            modalTitle.innerText = "Editar Categoría";
            form.action = "{{ url('/admin/categorias') }}/" + category.id;
            form.reset();
            
            document.getElementById('category_id').value = category.id;
            document.getElementById('name').value = category.name;
            document.getElementById('description').value = category.description;
            document.getElementById('img_url').value = category.img || '';
            document.getElementById('category_img_preview').src = category.display_image || "{{ asset('img/imgPrueba.png') }}";
            
            modal.style.display = "flex";
            setTimeout(() => modal.classList.add('active'), 10);
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
            if (url && url.trim() !== '') {
                preview.src = url;
                preview.onerror = function() {
                    this.src = "{{ asset('img/imgPrueba.png') }}";
                    alert('La URL no es una imagen válida. Por favor, verifica que la URL sea una imagen directa.');
                };
            } else {
                preview.src = "{{ asset('img/imgPrueba.png') }}";
            }
        }

        function closeModal() {
            modal.classList.remove('active');
            setTimeout(() => modal.style.display = "none", 300);
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
    @endpush
</x-admin.layout>
