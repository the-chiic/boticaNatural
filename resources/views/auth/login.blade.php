@extends('app')

@section('navbar')
    @include('components.navbar')
@endsection

@section('content')
<div class="contenedorAutenticacion">

    <div class="autenticacionIzquierda">
        <div class="envolturaFormulario">
            
            <div class="cabeceraAutenticacion">
                <a href="{{ url('/') }}" class="marca-premium">
                    <img src="{{ asset('img/logo.jpg') }}" alt="Logo La Botica Natural" class="iconoMarca">
                    <span class="nombreMarca">{{ \Illuminate\Support\Facades\Cache::get('shop_name', 'LA BOTICA NATURAL') }}</span>
                </a>
                <h1>BIENVENIDO DE NUEVO</h1>
                <p>Tu camino hacia el bienestar natural continúa aquí.</p>
            </div>

            <form id="formLogin" action="{{ route('login') }}" method="POST">
                @csrf
                
                @if (session('status'))
                    <div class="alert-status-success">
                        {{ session('status') }}
                    </div>
                @endif
                
                <div class="grupoFormulario">
                    <div class="cabeceraGrupoFormulario">
                         <label class="etiquetaFormulario" for="email">Correo Electrónico</label>
                    </div>
                    <input type="text" name="email" id="email" class="controlFormulario" placeholder="admin@boticanatural.com o tu email" value="{{ old('email') }}">
                    @error('email')
                        <span class="input-error-msg">{{ $message }}</span>
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
                    @error('password')
                        <span class="input-error-msg">{{ $message }}</span>
                    @enderror
                </div>



                <button type="submit" class="boton botonPrincipal">INICIAR SESIÓN</button>
            </form>

            <div style="margin-top: 2rem;"></div>

            <div class="divisor">O CONTINÚA CON</div>

            <a href="{{ route('login.google') }}" class="botonGoogleOriginal">
                <svg width="18" height="18" viewBox="0 0 18 18">
                    <path fill="#4285F4" d="M17.64 9.2c0-.63-.06-1.25-.16-1.84H9v3.47h4.84a4.14 4.14 0 0 1-1.8 2.71v2.26h2.91a8.78 8.78 0 0 0 2.69-6.6z"/>
                    <path fill="#34A853" d="M9 18c2.43 0 4.47-.8 5.96-2.2l-2.91-2.26a5.41 5.41 0 0 1-8.09-2.85h-3v2.33A9 9 0 0 0 9 18z"/>
                    <path fill="#FBBC05" d="M3.96 10.69a5.4 5.4 0 0 1 0-3.38V4.98h-3v2.33a9 9 0 0 0 0 7.71l3-2.33z"/>
                    <path fill="#EA4335" d="M9 3.58c1.32 0 2.5.45 3.44 1.35l2.58-2.59A9 9 0 0 0 1.25 4.98l3 2.33A5.41 5.41 0 0 1 9 3.58z"/>
                </svg>
                INICIAR SESIÓN CON GOOGLE
            </a>

            <p class="auth-footer-text">
                ¿No tienes cuenta? <a href="{{ url('registrarse') }}">Regístrate</a>
            </p>
        </div>

    </div>

    <div class="autenticacionDerecha">
        <img src="https://images.unsplash.com/photo-1511497584788-876760111969?q=80&w=1400&auto=format&fit=crop" alt="Fondo Montaña" class="imagenFondo">
        <div class="capaOscura"></div>
        <div class="contenidoDerecha">
            <h2>BIENESTAR DIARIO</h2>
            <p>"En cada caminata por la naturaleza uno recibe<br>mucho más de lo que busca."</p>
            <div class="linea"></div>
        </div>
    </div>
    
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/auth.js') }}"></script>
@endpush
