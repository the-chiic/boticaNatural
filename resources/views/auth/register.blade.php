@extends('layouts.app')

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
                <p>Empieza tu camino hacia el bienestar natural.</p>
            </div>

            <form action="#" method="POST">
                <div class="grupoFormulario">
                    <div class="cabeceraGrupoFormulario">
                        <label class="etiquetaFormulario" for="name">Nombre Completo</label>
                    </div>
                    <input type="text" id="name" class="controlFormulario" placeholder="Tu nombre">
                </div>

                <div class="grupoFormulario">
                    <div class="cabeceraGrupoFormulario">
                        <label class="etiquetaFormulario" for="email">Correo Electrónico</label>
                    </div>
                    <input type="email" id="email" class="controlFormulario" placeholder="tubotanica@gmail.com">
                </div>

                <div class="grupoFormulario">
                    <div class="cabeceraGrupoFormulario">
                        <label class="etiquetaFormulario" for="password">Contraseña</label>
                    </div>
                    <input type="password" id="password" class="controlFormulario" placeholder="........">
                </div>

                <div class="grupoFormulario">
                    <div class="cabeceraGrupoFormulario">
                        <label class="etiquetaFormulario" for="password_confirmation">Confirmar Contraseña</label>
                    </div>
                    <input type="password" id="password_confirmation" class="controlFormulario" placeholder="........">
                </div>

                <button type="submit" class="boton botonPrincipal">CREAR CUENTA</button>
            </form>

            <div class="divisor">O REGÍSTRATE CON</div>

            <button type="button" class="boton botonContorno">
                <i class="fa-brands fa-google iconoGoogle"></i>
                GOOGLE
            </button>
            
            <div style="text-align: center; margin-top: 1.875em; font-size: 0.875em; color: var(--color-texto-claro);">
                ¿Ya tienes una cuenta? <a href="/login" style="color: var(--color-principal); font-weight: 600;">Inicia sesión</a>
            </div>
        </div>
    </div>

    <!-- Parte derecha -->
    <div class="autenticacionDerecha">
        <img src="https://images.unsplash.com/photo-1511497584788-876760111969?q=80&w=1400&auto=format&fit=crop" alt="Bosque Verde" class="imagenFondo">
        <div class="capaOscura"></div>
        <div class="contenidoDerecha">
            <h2>NATURALEZA EN TI</h2>
            <p>"Descubre el equilibrio perfecto que<br>la botánica tiene reservado para tu salud."</p>
            <div class="linea"></div>
        </div>
    </div>
    
</div>
@endsection
