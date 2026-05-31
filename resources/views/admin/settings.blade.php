<x-admin.layout title="Configuración" subtitle="Ajustes generales de la tienda online.">

    @if(session('success'))
        <div class="alert-success">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div style="background-color: rgba(217, 48, 37, 0.1); color: #d93025; padding: 15px 20px; border-radius: 8px; margin-bottom: 25px; border-left: 4px solid #d93025; font-size: 14px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="settings-container">
        <!-- Formulario de Información de la Tienda -->
        <form action="{{ route('admin.configuracion.save.info') }}" method="POST">
            @csrf

            <div id="shopInfoErrors" style="display: none; background-color: rgba(217, 48, 37, 0.1); color: #d93025; padding: 12px 16px; border-radius: 6px; margin-bottom: 15px; border-left: 4px solid #d93025; font-size: 13px;"></div>

            <div class="settings-section">
                <div class="settings-info">
                    <h3>Información de la Tienda</h3>
                    <p>Actualiza los datos públicos de tu negocio. Estos datos aparecerán en las facturas de los clientes y en el pie de página de la web.</p>
                </div>
                <div class="settings-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="shop_name">Nombre Comercial</label>
                            <div class="input-with-icon">
                                <i class="fa-solid fa-store"></i>
                                <input type="text" id="shop_name" name="shop_name" value="{{ old('shop_name', $shopName) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="shop_nif">NIF / CIF</label>
                            <div class="input-with-icon">
                                <i class="fa-solid fa-id-card"></i>
                                <input type="text" id="shop_nif" name="shop_nif" value="{{ old('shop_nif', $shopNif) }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="shop_email">Correo de Contacto</label>
                            <div class="input-with-icon">
                                <i class="fa-solid fa-envelope"></i>
                                <input type="email" id="shop_email" name="shop_email" value="{{ old('shop_email', $shopEmail) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="shop_phone">Teléfono de Atención</label>
                            <div class="input-with-icon">
                                <i class="fa-solid fa-phone"></i>
                                <input type="text" id="shop_phone" name="shop_phone" value="{{ old('shop_phone', $shopPhone) }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="shop_address">Dirección Física Principal</label>
                        <div class="input-with-icon">
                            <i class="fa-solid fa-location-dot" style="top: 22px;"></i>
                            <textarea id="shop_address" name="shop_address" rows="3">{{ old('shop_address', $shopAddress) }}</textarea>
                        </div>
                    </div>

                    <div style="text-align: right; margin-top: 25px;">
                        <button type="submit" class="btn">Guardar Información de la Tienda</button>
                    </div>
                </div>
            </div>
        </form>

        <!-- Formulario de Preferencias y Alertas -->
        <form action="{{ route('admin.configuracion.save.preferences') }}" method="POST">
            @csrf

            <div class="settings-section">
                <div class="settings-info">
                    <h3>Preferencias y Alertas</h3>
                    <p>Configura el comportamiento general de la plataforma y decide qué notificaciones por correo electrónico quieres recibir.</p>
                </div>
                <div class="settings-form">
                    <div class="setting-row">
                        <div class="setting-row-text">
                            <h4>Modo Mantenimiento</h4>
                            <p>Oculta temporalmente la tienda al público. Los clientes verán una pantalla de "Volvemos pronto".</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="maintenance_mode" value="1" @if(old('maintenance_mode', $maintenanceMode)) checked @endif>
                        </label>
                    </div>
                    <div class="setting-row">
                        <div class="setting-row-text">
                            <h4>Notificaciones de Nuevos Pedidos</h4>
                            <p>Recibir un correo electrónico inmediatamente cada vez que un cliente finalice un pago.</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="notify_new_orders" value="1" @if(old('notify_new_orders', $notifyNewOrders)) checked @endif>
                        </label>
                    </div>
                    <div class="setting-row">
                        <div class="setting-row-text">
                            <h4>Alerta de Stock Crítico</h4>
                            <p>Aviso automático diario cuando el inventario de un producto descienda a menos de 5 unidades.</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="stock_alert" value="1" @if(old('stock_alert', $stockAlert)) checked @endif>
                        </label>
                    </div>

                    <div class="form-row" style="margin-top: 25px; padding-top: 25px; border-top: 1px solid #eee;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label>Moneda Principal</label>
                            <select disabled>
                                <option value="EUR" selected>Euro (€)</option>
                                <option value="USD">Dólar ($)</option>
                                <option value="GBP">Libra Esterlina (£)</option>
                            </select>
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label>Idioma por Defecto</label>
                            <select disabled>
                                <option value="es" selected>Español (ES)</option>
                                <option value="en">Inglés (EN)</option>
                            </select>
                        </div>
                    </div>

                    <div style="text-align: right; margin-top: 25px;">
                        <button type="submit" class="btn">Guardar Preferencias</button>
                    </div>
                </div>
            </div>
        </form>

        <!-- Formulario de Seguridad de la Cuenta -->
        <div class="settings-section">
            <div class="settings-info">
                <h3>Seguridad de la Cuenta</h3>
                <p>Gestiona tu contraseña de administrador para mantener la tienda segura y evitar accesos no autorizados.</p>
            </div>
            <div class="settings-form">
                <div id="securityErrors" style="display: none; background-color: rgba(217, 48, 37, 0.1); color: #d93025; padding: 12px 16px; border-radius: 6px; margin-bottom: 15px; border-left: 4px solid #d93025; font-size: 13px;"></div>

                <form action="{{ route('admin.configuracion.security') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="current_password">Contraseña Actual</label>
                        <div class="input-with-icon">
                            <i class="fa-solid fa-lock"></i>
                            <input type="password" id="current_password" name="current_password" placeholder="Introduce tu contraseña actual">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="password">Nueva Contraseña</label>
                            <div class="input-with-icon">
                                <i class="fa-solid fa-key"></i>
                                <input type="password" id="password" name="password" placeholder="Mínimo 8 caracteres">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirmar Nueva Contraseña</label>
                            <div class="input-with-icon">
                                <i class="fa-solid fa-key"></i>
                                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Repite la contraseña">
                            </div>
                        </div>
                    </div>
                    
                    <div style="text-align: right; margin-top: 10px;">
                        <button type="submit" class="btn">Actualizar Contraseña</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Validar formulario de Información de la Tienda
        document.querySelector('form[action="{{ route('admin.configuracion.save.info') }}"]').addEventListener('submit', function(e) {
            e.preventDefault();

            const emptyFields = [];
            const shopName = document.getElementById('shop_name').value.trim();
            const shopNif = document.getElementById('shop_nif').value.trim();
            const shopEmail = document.getElementById('shop_email').value.trim();
            const shopPhone = document.getElementById('shop_phone').value.trim();
            const shopAddress = document.getElementById('shop_address').value.trim();

            if (!shopName) emptyFields.push('Nombre Comercial');
            if (!shopNif) emptyFields.push('NIF / CIF');
            if (!shopEmail) emptyFields.push('Correo de Contacto');
            if (!shopPhone) emptyFields.push('Teléfono de Atención');
            if (!shopAddress) emptyFields.push('Dirección Física Principal');

            const errorContainer = document.getElementById('shopInfoErrors');
            if (emptyFields.length > 0) {
                const message = 'Por favor, rellena los siguientes campos: ' + emptyFields.join(', ');
                errorContainer.textContent = message;
                errorContainer.style.display = 'block';
                return;
            }

            errorContainer.style.display = 'none';
            this.submit();
        });

        // Validar formulario de Seguridad de la Cuenta
        document.querySelector('form[action="{{ route('admin.configuracion.security') }}"]').addEventListener('submit', function(e) {
            e.preventDefault();

            const emptyFields = [];
            const currentPassword = document.getElementById('current_password').value.trim();
            const password = document.getElementById('password').value.trim();
            const passwordConfirmation = document.getElementById('password_confirmation').value.trim();

            if (!currentPassword) emptyFields.push('Contraseña Actual');
            if (!password) emptyFields.push('Nueva Contraseña');
            if (!passwordConfirmation) emptyFields.push('Confirmar Nueva Contraseña');

            const errorContainer = document.getElementById('securityErrors');
            if (emptyFields.length > 0) {
                const message = 'Por favor, rellena los siguientes campos: ' + emptyFields.join(', ');
                errorContainer.textContent = message;
                errorContainer.style.display = 'block';
                return;
            }

            if (password !== passwordConfirmation) {
                errorContainer.textContent = 'La nueva contraseña y la confirmación no coinciden.';
                errorContainer.style.display = 'block';
                return;
            }

            errorContainer.style.display = 'none';
            this.submit();
        });
    </script>
    @endpush
</x-admin.layout>
