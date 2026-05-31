@extends('app')

@section('navbar')
    @include('components.navbar')
@endsection

@section('content')
<div class="contenedorAutenticacion">

    <div class="autenticacionIzquierda">
        <div class="envolturaFormulario">
            
            <div class="cabeceraAutenticacion" style="text-align: center;">
                <div class="marca">
                    <i class="fa-solid fa-leaf iconoMarca"></i>
                    LA BOTICA NATURAL
                </div>
                <div style="font-size: 3.5rem; color: var(--color-acento); margin-bottom: 1rem; margin-top: 1rem;">
                    <i class="fa-solid fa-envelope-circle-check"></i>
                </div>
                <h1>VERIFICA TU CORREO</h1>
                <p style="margin-top: 1rem; line-height: 1.6;">
                    ¡Te hemos enviado un correo de activación! Por favor, revisa tu bandeja de entrada y haz clic en el enlace que te enviamos para activar tu cuenta.
                </p>
            </div>

            @if (session('status'))
                <div style="background-color: #dcfce7; color: #166534; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; font-size: 0.875rem; text-align: center; border: 1px solid #bbf7d0;">
                    {{ session('status') }}
                </div>
            @endif

            <div style="background-color: #f9f9f9; padding: 1.25rem; border-radius: 0.75rem; border: 1px solid #eaeaea; margin-bottom: 2rem; text-align: center;">
                <p style="font-size: 0.875rem; color: var(--color-texto-claro); margin-bottom: 0;">
                    ¿No has recibido el correo? Asegúrate de revisar tu carpeta de correo no deseado (spam).
                </p>
            </div>

            <form action="{{ route('verification.send') }}" method="POST" style="text-align: center;">
                @csrf
                <input type="hidden" name="email" value="{{ session('verify_email') }}">
                <button type="submit" class="boton botonPrincipal">REENVIAR CORREO</button>
            </form>

            <p style="text-align: center; margin-top: 2rem; font-size: 0.875rem;">
                <a href="{{ url('iniciar-sesion') }}" style="color: var(--color-principal); font-weight: 700;">Volver al Inicio de Sesión</a>
            </p>
        </div>

    </div>

    <div class="autenticacionDerecha">
        <img src="https://images.unsplash.com/photo-1506084868230-bb9d95c24759?q=80&w=1400&auto=format&fit=crop" alt="Fondo Naturaleza" class="imagenFondo">
        <div class="capaOscura"></div>
        <div class="contenidoDerecha">
            <h2>BIENVENIDO A BORDO</h2>
            <p>"La naturaleza siempre viste los colores del espíritu."</p>
            <div class="linea"></div>
        </div>
    </div>
    
</div>
@endsection
