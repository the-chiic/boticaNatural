@extends('app')

@section('navbar')
@endsection

@section('content')
<div class="contenedorAutenticacion">

    <div class="autenticacionIzquierda">
        <div class="envolturaFormulario">
            
            <div class="cabeceraAutenticacion">
                <a href="{{ url('/') }}" class="marca-premium" style="justify-content: center; margin-bottom: 2rem;">
                    <img src="{{ asset('img/logo.jpg') }}" alt="Logo La Botica Natural" class="iconoMarca">
                    <span class="nombreMarca">{{ \Illuminate\Support\Facades\Cache::get('shop_name', 'LA BOTICA NATURAL') }}</span>
                </a>
                <h1>ACCESO ADMINISTRADOR</h1>
                <p>Panel de gestión de La Botica Natural</p>
            </div>

            <form id="formLogin" action="{{ route('admin.login') }}" method="POST">
                @csrf
                
                @if (session('status'))
                    <div style="background-color: #dcfce7; color: #166534; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem; font-size: 0.875rem; text-align: center; border: 1px solid #bbf7d0;">
                        {{ session('status') }}
                    </div>
                @endif
                
                <div class="grupoFormulario">
                    <div class="cabeceraGrupoFormulario">
                        <label class="etiquetaFormulario" for="email">Correo Electrónico</label>
                    </div>
                    <input type="email" name="email" id="email" class="controlFormulario" placeholder="admin@botica.com" value="{{ old('email') }}" autofocus>
                    <span id="email-error" style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: none;"></span>
                    @error('email')
                        <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grupoFormulario">
                    <div class="cabeceraGrupoFormulario">
                        <label class="etiquetaFormulario" for="password">Contraseña</label>
                    </div>
                    <div class="posicionadorContrasena">
                        <input type="password" name="password" id="password" class="controlFormulario" placeholder="........">
                        <button type="button" class="btn-toggle-password" aria-label="Mostrar contraseña">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                    <span id="password-error" style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: none;"></span>
                    @error('password')
                        <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="boton botonPrincipal">INICIAR SESIÓN</button>
            </form>

            <p style="text-align: center; margin-top: 2rem; font-size: 0.875rem;">
                <a href="{{ url('/') }}" style="color: var(--color-principal); font-weight: 700;">Volver a la tienda</a>
            </p>
        </div>

    </div>

    <!-- Parte derecha -->
    <div class="autenticacionDerecha">
        <img src="https://images.unsplash.com/photo-1556761175-5973dc0f32e7?q=80&w=1400&auto=format&fit=crop" alt="Fondo Oficina" class="imagenFondo">
        <div class="capaOscura"></div>
        <div class="contenidoDerecha">
            <h2>PANEL DE ADMINISTRACIÓN</h2>
            <p>Gestiona productos, pedidos,<br>clientes y configuración</p>
            <div class="linea"></div>
        </div>
    </div>
    
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/auth.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formLogin');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const emailError = document.getElementById('email-error');
    const passwordError = document.getElementById('password-error');

    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        // Reset errores
        emailError.style.display = 'none';
        emailError.textContent = '';
        passwordError.style.display = 'none';
        passwordError.textContent = '';
        
        // Validar email
        if (!emailInput.value.trim()) {
            emailError.textContent = 'El correo electrónico es obligatorio.';
            emailError.style.display = 'block';
            isValid = false;
        } else if (!emailInput.value.includes('@')) {
            emailError.textContent = 'El formato del correo electrónico no es válido.';
            emailError.style.display = 'block';
            isValid = false;
        }
        
        // Validar password
        if (!passwordInput.value.trim()) {
            passwordError.textContent = 'La contraseña es obligatoria.';
            passwordError.style.display = 'block';
            isValid = false;
        }
        
        if (!isValid) {
            e.preventDefault();
        }
    });
});
</script>
@endpush
