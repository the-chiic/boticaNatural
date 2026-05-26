@extends('app')

@section('navbar')
    @include('components.navbar')
@endsection

@section('content')
<div class="contenedorAutenticacion">

    <div class="autenticacionIzquierda">
        <div class="envolturaFormulario">
            
            <div class="cabeceraAutenticacion">
                <div class="marca">
                    <i class="fa-solid fa-leaf iconoMarca"></i>
                    {{ \Illuminate\Support\Facades\Cache::get('shop_name', 'LA BOTICA NATURAL') }}
                </div>
                <h1>BIENVENIDO DE NUEVO</h1>
                <p>Tu camino hacia el bienestar natural continúa aquí.</p>
            </div>

            <form action="{{ route('login') }}" method="POST">
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
                    <input type="email" name="email" id="email" class="controlFormulario" placeholder="admin@boticanatural.com o tu email" value="{{ old('email') }}" required>
                    @error('email')
                        <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grupoFormulario">
                    <div class="cabeceraGrupoFormulario">
                        <label class="etiquetaFormulario" for="password">Contraseña</label>
                        <a href="#" class="enlaceOlvido">¿Olvidaste tu contraseña?</a>
                    </div>
                    <input type="password" name="password" id="password" class="controlFormulario" placeholder="........" required>
                    @error('password')
                        <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="boton botonPrincipal">INICIAR SESIÓN</button>
            </form>

            <div class="divisor">O CONTINÚA CON</div>

            <a href="{{ route('login.google') }}" class="boton botonContorno" style="text-decoration: none; display: flex; justify-content: center;">
                <i class="fa-brands fa-google iconoGoogle"></i>
                GOOGLE
            </a>

            <p style="text-align: center; margin-top: 2rem; font-size: 0.875rem;">
                ¿No tienes cuenta? <a href="/registrarse" style="color: var(--color-principal); font-weight: 700;">Regístrate</a>
            </p>
        </div>

    </div>

    <!-- Parte derecha -->
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
