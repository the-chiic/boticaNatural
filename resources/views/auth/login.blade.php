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
                <h1>BIENVENIDO DE NUEVO</h1>
                <p>Tu camino hacia el bienestar natural continúa aquí.</p>
            </div>

            <form action="#" method="POST">
                <div class="grupoFormulario">
                    <div class="cabeceraGrupoFormulario">
                        <label class="etiquetaFormulario" for="email">Correo Electrónico</label>
                    </div>
                    <input type="email" id="email" class="controlFormulario" placeholder="tubotanica@gmail.com">
                </div>

                <div class="grupoFormulario">
                    <div class="cabeceraGrupoFormulario">
                        <label class="etiquetaFormulario" for="password">Contraseña</label>
                        <a href="#" class="enlaceOlvido">¿Olvidaste tu contraseña?</a>
                    </div>
                    <input type="password" id="password" class="controlFormulario" placeholder="........">
                </div>

                <button type="submit" class="boton botonPrincipal">INICIAR SESIÓN</button>
            </form>

            <div class="divisor">O CONTINÚA CON</div>

            <button type="button" class="boton botonContorno">
                <i class="fa-brands fa-google iconoGoogle"></i>
                GOOGLE
            </button>
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
