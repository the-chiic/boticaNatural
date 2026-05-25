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
                    <tr>
                        <td>
                            <div class="thumb {{ $colors[$loop->index % 4] }}">
                                <i class="fa-solid fa-tags" style="font-size: 16px;"></i>
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
                                onclick="openEditModal({
                                    id: '{{ $category->id }}',
                                    name: '{{ addslashes($category->name) }}',
                                    description: '{{ addslashes($category->description) }}'
                                })">
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
    </div>

    <!-- Modal Box -->
    <div id="categoryModal" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-header">
                <h3 id="modalTitle">Nueva Categoría</h3>
                <button class="modal-close" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body">
                <form id="categoryForm" action="{{ route('admin.categorias.store') }}" method="POST">
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
            
            modal.style.display = "flex";
            setTimeout(() => modal.classList.add('active'), 10);
        }

        function openEditModal(category) {
            modalTitle.innerText = "Editar Categoría";
            form.action = `/admin/categorias/${category.id}`;
            
            document.getElementById('category_id').value = category.id;
            document.getElementById('name').value = category.name;
            document.getElementById('description').value = category.description;
            
            modal.style.display = "flex";
            setTimeout(() => modal.classList.add('active'), 10);
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
