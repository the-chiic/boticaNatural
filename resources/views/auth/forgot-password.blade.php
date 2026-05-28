@extends('app')

@section('navbar')
    @include('components.navbar')
@endsection

@section('content')
<div class="contenedorAutenticacion">

    <div class="autenticacionIzquierda">
        <div class="envolturaFormulario">
            
            <div class="cabeceraAutenticacion">
                <div class="marca marca-premium" style="justify-content: center; margin-bottom: 1rem;">
                    <img src="{{ asset('img/logo.jpg') }}" alt="Sello La Botica Natural" class="iconoMarca" style="width: 70px; height: 70px; border-radius: 50%; object-fit: cover; border: 2px solid rgba(27,48,34,0.12); box-shadow: 0 4px 15px rgba(27,48,34,0.1);">
                </div>
                <h1>RECUPERAR CONTRASEÑA</h1>
                <p>Te enviaremos un enlace de recuperación a tu bandeja de entrada.</p>
            </div>

            <form id="formForgotPassword" action="{{ route('password.email') }}" method="POST">
                @csrf
                
                @if (session('status'))
                    <div style="background-color: #dcfce7; color: #166534; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem; font-size: 0.875rem; text-align: center; border: 1px solid #bbf7d0;">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div style="background-color: #fef2f2; color: #991b1b; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem; font-size: 0.875rem; text-align: center; border: 1px solid #fee2e2;">
                        {{ $errors->first() }}
                    </div>
                @endif
                
                <div class="grupoFormulario">
                    <div class="cabeceraGrupoFormulario">
                        <label class="etiquetaFormulario" for="email">Correo Electrónico</label>
                    </div>
                    <input type="email" name="email" id="email" class="controlFormulario" placeholder="ejemplo@correo.com" value="{{ old('email') }}">
                </div>

                <button type="submit" class="boton botonPrincipal">ENVIAR ENLACE</button>
            </form>

            <p style="text-align: center; margin-top: 2rem; font-size: 0.875rem;">
                ¿Recordaste tu contraseña? <a href="{{ url('iniciar-sesion') }}" style="color: var(--color-principal); font-weight: 700;">Inicia sesión</a>
            </p>
        </div>

    </div>

    <!-- Parte derecha -->
    <div class="autenticacionDerecha">
        <img src="https://images.unsplash.com/photo-1512290923902-8a9f81dc236c?q=80&w=1400&auto=format&fit=crop" alt="Fondo Hojas" class="imagenFondo">
        <div class="capaOscura"></div>
        <div class="contenidoDerecha">
            <h2>CUIDADO NATURAL</h2>
            <p>"La salud es la riqueza real y no las piezas de oro y plata."</p>
            <div class="linea"></div>
        </div>
    </div>
    
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('formForgotPassword');
    const emailInput = document.getElementById('email');
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    function showError(inputElement, message) {
        clearError(inputElement);
        inputElement.classList.add('invalido');
        const errorDiv = document.createElement('div');
        errorDiv.className = 'errorFeedback';
        errorDiv.innerHTML = `<i class="fa-solid fa-circle-exclamation"></i> <span>${message}</span>`;
        inputElement.parentNode.appendChild(errorDiv);
    }

    function clearError(inputElement) {
        inputElement.classList.remove('invalido');
        const feedback = inputElement.parentNode.querySelector('.errorFeedback');
        if (feedback) {
            inputElement.parentNode.removeChild(feedback);
        }
    }

    emailInput.addEventListener('input', () => {
        clearError(emailInput);
    });

    form.addEventListener('submit', (e) => {
        let isValid = true;
        if (!emailInput.value.trim()) {
            showError(emailInput, 'El correo electrónico es obligatorio.');
            isValid = false;
        } else if (!emailRegex.test(emailInput.value.trim())) {
            showError(emailInput, 'El correo electrónico no es válido.');
            isValid = false;
        }
        
        if (!isValid) {
            e.preventDefault();
        }
    });
});
</script>
@endpush
