@extends('layouts.app')

@section('content')
<div class="auth-container">

    <div class="auth-left">
        <div class="auth-form-wrapper">
            
            <div class="auth-header">
                <div class="brand">
                    <i class="fa-solid fa-leaf brand-icon"></i>
                    LA BOTICA NATURAL
                </div>
                <h1>BIENVENIDO DE NUEVO</h1>
                <p>Tu camino hacia el bienestar natural continúa aquí.</p>
            </div>

            <form action="#" method="POST">
                <div class="form-group">
                    <div class="form-group-header">
                        <label class="form-label" for="email">Correo Electrónico</label>
                    </div>
                    <input type="email" id="email" class="form-control" placeholder="tubotanica@gmail.com">
                </div>

                <div class="form-group">
                    <div class="form-group-header">
                        <label class="form-label" for="password">Contraseña</label>
                        <a href="#" class="forgot-link">¿Olvidaste tu contraseña?</a>
                    </div>
                    <input type="password" id="password" class="form-control" placeholder="........">
                </div>

                <button type="submit" class="btn btn-primary">INICIAR SESIÓN</button>
            </form>

            <div class="divider">O CONTINÚA CON</div>

            <button type="button" class="btn btn-outline">
                <i class="fa-brands fa-google google-icon"></i>
                GOOGLE
            </button>
        </div>

        <div class="auth-footer">
            ¿No tienes una cuenta? <a href="#">Crea una ahora</a>
        </div>
    </div>

    <!-- Parte derecha -->
    <div class="auth-right">
        <img src="https://images.unsplash.com/photo-1511497584788-876760111969?q=80&w=1400&auto=format&fit=crop" alt="Fondo Montaña" class="imagen-fondo">
        <div class="capa-oscura"></div>
        <div class="auth-right-content">
            <h2>BIENESTAR DIARIO</h2>
            <p>"En cada caminata por la naturaleza uno recibe<br>mucho más de lo que busca."</p>
            <div class="line"></div>
        </div>
    </div>
    
</div>
@endsection
