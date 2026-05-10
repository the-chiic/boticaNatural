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

            <form action="#" method="POST">
                @csrf
                <div class="grupoFormulario">
                    <label class="etiquetaFormulario" for="name">Nombre Completo</label>
                    <input type="text" id="name" class="controlFormulario" placeholder="Tu nombre">
                </div>

                <div class="grupoFormulario">
                    <label class="etiquetaFormulario" for="email">Correo Electrónico</label>
                    <input type="email" id="email" class="controlFormulario" placeholder="ejemplo@correo.com">
                </div>

                <div class="grupoFormulario">
                    <label class="etiquetaFormulario" for="password">Contraseña</label>
                    <input type="password" id="password" class="controlFormulario" placeholder="Mínimo 8 caracteres">
                </div>

                <div class="grupoFormulario">
                    <label class="etiquetaFormulario" for="password_confirmation">Confirmar Contraseña</label>
                    <input type="password" id="password_confirmation" class="controlFormulario" placeholder="Repite tu contraseña">
                </div>

                <button type="submit" class="boton botonPrincipal">CREAR CUENTA</button>
            </form>

            <div class="divisor">O REGÍSTRATE CON</div>

            <button type="button" class="boton botonContorno">
                <i class="fa-brands fa-google iconoGoogle"></i>
                GOOGLE
            </button>

            <p style="text-align: center; margin-top: 2rem; font-size: 0.875rem;">
                ¿Ya tienes cuenta? <a href="/login" style="color: var(--color-principal); font-weight: 700;">Inicia sesión</a>
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
