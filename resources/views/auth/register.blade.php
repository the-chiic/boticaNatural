@extends('layouts.app')

@section('content')
<div class="contenedor-autenticacion">

    <div class="autenticacion-izquierda">
        <div class="envoltura-formulario">
            
            <div class="cabecera-autenticacion">
                <div class="marca">
                    <i class="fa-solid fa-leaf icono-marca"></i>
                    LA BOTICA NATURAL
                </div>
                <h1>ÚNETE A NOSOTROS</h1>
                <p>Empieza tu camino hacia el bienestar natural.</p>
            </div>

            <form action="#" method="POST">
                <div class="grupo-formulario">
                    <div class="cabecera-grupo-formulario">
                        <label class="etiqueta-formulario" for="name">Nombre Completo</label>
                    </div>
                    <input type="text" id="name" class="control-formulario" placeholder="Tu nombre">
                </div>

                <div class="grupo-formulario">
                    <div class="cabecera-grupo-formulario">
                        <label class="etiqueta-formulario" for="email">Correo Electrónico</label>
                    </div>
                    <input type="email" id="email" class="control-formulario" placeholder="tubotanica@gmail.com">
                </div>

                <div class="grupo-formulario">
                    <div class="cabecera-grupo-formulario">
                        <label class="etiqueta-formulario" for="password">Contraseña</label>
                    </div>
                    <input type="password" id="password" class="control-formulario" placeholder="........">
                </div>

                <div class="grupo-formulario">
                    <div class="cabecera-grupo-formulario">
                        <label class="etiqueta-formulario" for="password_confirmation">Confirmar Contraseña</label>
                    </div>
                    <input type="password" id="password_confirmation" class="control-formulario" placeholder="........">
                </div>

                <button type="submit" class="boton boton-principal">CREAR CUENTA</button>
            </form>

            <div class="divisor">O REGÍSTRATE CON</div>

            <button type="button" class="boton boton-contorno">
                <i class="fa-brands fa-google icono-google"></i>
                GOOGLE
            </button>
            
            <div style="text-align: center; margin-top: 1.875em; font-size: 0.875em; color: var(--color-texto-claro);">
                ¿Ya tienes una cuenta? <a href="/login" style="color: var(--color-principal); font-weight: 600;">Inicia sesión</a>
            </div>
        </div>
    </div>

    <!-- Parte derecha -->
    <div class="autenticacion-derecha">
        <img src="https://images.unsplash.com/photo-1511497584788-876760111969?q=80&w=1400&auto=format&fit=crop" alt="Bosque Verde" class="imagen-fondo">
        <div class="capa-oscura"></div>
        <div class="contenido-derecha">
            <h2>NATURALEZA EN TI</h2>
            <p>"Descubre el equilibrio perfecto que<br>la botánica tiene reservado para tu salud."</p>
            <div class="linea"></div>
        </div>
    </div>
    
</div>
@endsection
