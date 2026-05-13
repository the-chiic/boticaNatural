<x-admin.layout title="Configuración" subtitle="Ajustes generales de la tienda online.">
    <div class="settings-container">
        <div class="settings-section">
            <div class="settings-info">
                <h3>Información de la Tienda</h3>
                <p>Actualiza los datos públicos de tu negocio. Estos datos aparecerán en las facturas de los clientes y en el pie de página de la web.</p>
            </div>
            <div class="settings-form">
                <form>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Nombre Comercial</label>
                            <div class="input-with-icon">
                                <i class="fa-solid fa-store"></i>
                                <input type="text" value="La Botica Natural">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>NIF / CIF</label>
                            <div class="input-with-icon">
                                <i class="fa-solid fa-id-card"></i>
                                <input type="text" value="B-12345678">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Correo de Contacto</label>
                            <div class="input-with-icon">
                                <i class="fa-solid fa-envelope"></i>
                                <input type="email" value="contacto@laboticanatural.com">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Teléfono de Atención</label>
                            <div class="input-with-icon">
                                <i class="fa-solid fa-phone"></i>
                                <input type="text" value="+34 900 123 456">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Dirección Física Principal</label>
                        <div class="input-with-icon">
                            <i class="fa-solid fa-location-dot" style="top: 22px;"></i>
                            <textarea rows="3">Calle de la Naturaleza, 42&#10;Madrid, 28014</textarea>
                        </div>
                    </div>
                    <div style="text-align: right; margin-top: 10px;">
                        <button type="button" class="btn">Guardar Información</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="settings-section">
            <div class="settings-info">
                <h3>Seguridad de la Cuenta</h3>
                <p>Gestiona tu contraseña de administrador para mantener la tienda segura y evitar accesos no autorizados.</p>
            </div>
            <div class="settings-form">
                <form>
                    <div class="form-group">
                        <label>Contraseña Actual</label>
                        <div class="input-with-icon">
                            <i class="fa-solid fa-lock"></i>
                            <input type="password" placeholder="Introduce tu contraseña actual">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Nueva Contraseña</label>
                            <div class="input-with-icon">
                                <i class="fa-solid fa-key"></i>
                                <input type="password" placeholder="••••••••">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Confirmar Nueva Contraseña</label>
                            <div class="input-with-icon">
                                <i class="fa-solid fa-key"></i>
                                <input type="password" placeholder="••••••••">
                            </div>
                        </div>
                    </div>
                    <div style="text-align: right; margin-top: 10px;">
                        <button type="button" class="btn">Actualizar Contraseña</button>
                    </div>
                </form>
            </div>
        </div>

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
                        <input type="checkbox">
                    </label>
                </div>
                <div class="setting-row">
                    <div class="setting-row-text">
                        <h4>Notificaciones de Nuevos Pedidos</h4>
                        <p>Recibir un correo electrónico inmediatamente cada vez que un cliente finalice un pago.</p>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" checked>
                    </label>
                </div>
                <div class="setting-row">
                    <div class="setting-row-text">
                        <h4>Alerta de Stock Crítico</h4>
                        <p>Aviso automático diario cuando el inventario de un producto descienda a menos de 5 unidades.</p>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" checked>
                    </label>
                </div>
                <div class="form-row" style="margin-top: 25px; padding-top: 25px; border-top: 1px solid #eee;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Moneda Principal</label>
                        <select>
                            <option value="EUR" selected>Euro (€)</option>
                            <option value="USD">Dólar ($)</option>
                            <option value="GBP">Libra Esterlina (£)</option>
                        </select>
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Idioma por Defecto</label>
                        <select>
                            <option value="es" selected>Español (ES)</option>
                            <option value="en">Inglés (EN)</option>
                        </select>
                    </div>
                </div>
                <div style="text-align: right; margin-top: 25px;">
                    <button type="button" class="btn">Guardar Preferencias</button>
                </div>
            </div>
        </div>
    </div>
</x-admin.layout>
