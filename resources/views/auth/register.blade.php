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
                    LA BOTICA NATURAL
                </div>
                <h1>ÚNETE A NOSOTROS</h1>
                <p>Comienza tu viaje hacia una vida más natural y consciente.</p>
            </div>

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="grupoFormulario">
                    <label class="etiquetaFormulario" for="name">Nombre Completo</label>
                    <input type="text" name="name" id="name" class="controlFormulario" placeholder="Tu nombre" value="{{ old('name') }}" required>
                    @error('name')
                        <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grupoFormulario">
                    <label class="etiquetaFormulario" for="email">Correo Electrónico</label>
                    <input type="email" name="email" id="email" class="controlFormulario" placeholder="ejemplo@correo.com" value="{{ old('email') }}" required>
                    @error('email')
                        <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grupoFormulario">
                    <label class="etiquetaFormulario" for="password">Contraseña</label>
                    <input type="password" name="password" id="password" class="controlFormulario" placeholder="Mínimo 8 caracteres" required>
                    @error('password')
                        <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grupoFormulario">
                    <label class="etiquetaFormulario" for="password_confirmation">Confirmar Contraseña</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="controlFormulario" placeholder="Repite tu contraseña" required>
                </div>

                <button type="submit" class="boton botonPrincipal">CREAR CUENTA</button>
            </form>

            <div class="divisor">O REGÍSTRATE CON</div>

            <a href="{{ route('login.google') }}" class="boton botonContorno" style="text-decoration: none; display: flex; justify-content: center;">
                <i class="fa-brands fa-google iconoGoogle"></i>
                GOOGLE
            </a>

            <p style="text-align: center; margin-top: 2rem; font-size: 0.875rem;">
                ¿Ya tienes cuenta? <a href="/iniciar-sesion" style="color: var(--color-principal); font-weight: 700;">Inicia sesión</a>
            </p>
        </div>

    </div>

    <!-- Parte derecha -->
    <div class="autenticacionDerecha">
        <img src="https://images.unsplash.com/photo-1543269865-cbf427effbad?q=80&w=1400&auto=format&fit=crop" alt="Fondo Comunidad" class="imagenFondo">
        <div class="capaOscura"></div>
        <div class="contenidoDerecha">
            <h2>COMUNIDAD NATURAL</h2>
            <p>"La naturaleza no hace nada incompleto ni nada en vano."</p>
            <div class="linea"></div>
        </div>
    </div>
    
</div>
@endsection
