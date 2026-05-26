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
                <h1>RESTABLECER CONTRASEÑA</h1>
                <p>Ingresa tu nueva contraseña para acceder a tu cuenta.</p>
            </div>

            <form id="formResetPassword" action="{{ route('password.update') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                
                @if ($errors->any())
                    <div style="background-color: #fef2f2; color: #991b1b; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem; font-size: 0.875rem; text-align: center; border: 1px solid #fee2e2;">
                        {{ $errors->first() }}
                    </div>
                @endif
                
                <div class="grupoFormulario">
                    <label class="etiquetaFormulario" for="email">Correo Electrónico</label>
                    <input type="email" name="email" id="email" class="controlFormulario" value="{{ $email }}" readonly style="background-color: #f5f5f5; cursor: not-allowed;">
                </div>

                <div class="grupoFormulario">
                    <label class="etiquetaFormulario" for="password">Nueva Contraseña</label>
                    <input type="password" name="password" id="password" class="controlFormulario" placeholder="Nueva contraseña segura">
                </div>

                <div class="grupoFormulario">
                    <label class="etiquetaFormulario" for="password_confirmation">Confirmar Nueva Contraseña</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="controlFormulario" placeholder="Repite tu contraseña">
                </div>

                <button type="submit" class="boton botonPrincipal">ACTUALIZAR CONTRASEÑA</button>
            </form>
        </div>

    </div>

    <!-- Parte derecha -->
    <div class="autenticacionDerecha">
        <img src="https://images.unsplash.com/photo-1543269865-cbf427effbad?q=80&w=1400&auto=format&fit=crop" alt="Fondo Comunidad" class="imagenFondo">
        <div class="capaOscura"></div>
        <div class="contenidoDerecha">
            <h2>NUEVO COMIENZO</h2>
            <p>"La fuerza de la naturaleza reside en su constante renovación."</p>
            <div class="linea"></div>
        </div>
    </div>
    
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('formResetPassword');
    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('password_confirmation');

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

    // Limpiar errores en tiempo real cuando el usuario escribe
    document.querySelectorAll('.controlFormulario').forEach(input => {
        input.addEventListener('input', () => {
            if (input.classList.contains('invalido')) {
                clearError(input);
            }
        });
    });

    if (passwordInput) {
        // Añadir el contenedor de la barra de fuerza
        const strengthMeter = document.createElement('div');
        strengthMeter.className = 'passwordStrengthMeter';
        strengthMeter.innerHTML = `
            <div class="passwordStrengthBar" id="bar1"></div>
            <div class="passwordStrengthBar" id="bar2"></div>
            <div class="passwordStrengthBar" id="bar3"></div>
            <div class="passwordStrengthBar" id="bar4"></div>
        `;
        passwordInput.parentNode.appendChild(strengthMeter);

        // Añadir los requisitos con checkmarks dinámicos
        const reqInfo = document.createElement('div');
        reqInfo.className = 'passwordRequirementsInfo';
        reqInfo.innerHTML = `
            <p style="font-weight:600; margin-bottom:0.25em;">La contraseña debe cumplir con:</p>
            <ul>
                <li id="req-length" class="incumplido"><i class="fa-solid fa-circle-xmark"></i> Mínimo 8 caracteres</li>
                <li id="req-upper" class="incumplido"><i class="fa-solid fa-circle-xmark"></i> Al menos una letra mayúscula</li>
                <li id="req-lower" class="incumplido"><i class="fa-solid fa-circle-xmark"></i> Al menos una letra minúscula</li>
                <li id="req-number" class="incumplido"><i class="fa-solid fa-circle-xmark"></i> Al menos un número</li>
                <li id="req-special" class="incumplido"><i class="fa-solid fa-circle-xmark"></i> Al menos un carácter especial (@$!%*?&_#)</li>
            </ul>
        `;
        passwordInput.parentNode.appendChild(reqInfo);

        // Lógica de evaluación en tiempo real de la contraseña
        passwordInput.addEventListener('input', () => {
            const val = passwordInput.value;
            
            // Criterios
            const hasLength = val.length >= 8;
            const hasUpper = /[A-Z]/.test(val);
            const hasLower = /[a-z]/.test(val);
            const hasNumber = /[0-9]/.test(val);
            const hasSpecial = /[@$!%*?&_#\-\+\(\)\[\]\{\}\.\,\:\;\/\=\?\|]/.test(val);

            // Actualizar interfaz de requisitos
            updateRequirementUI('req-length', hasLength);
            updateRequirementUI('req-upper', hasUpper);
            updateRequirementUI('req-lower', hasLower);
            updateRequirementUI('req-number', hasNumber);
            updateRequirementUI('req-special', hasSpecial);

            // Calcular barra de nivel de seguridad (de 0 a 4)
            let score = 0;
            if (val.length > 0) {
                if (hasLength) score++;
                if (hasUpper && hasLower) score++;
                if (hasNumber) score++;
                if (hasSpecial) score++;
            }

            updateStrengthBars(score);
        });
    }

    function updateRequirementUI(elementId, met) {
        const el = document.getElementById(elementId);
        if (!el) return;
        if (met) {
            el.className = 'cumplido';
            el.innerHTML = `<i class="fa-solid fa-circle-check"></i> ${el.innerText.trim()}`;
        } else {
            el.className = 'incumplido';
            el.innerHTML = `<i class="fa-solid fa-circle-xmark"></i> ${el.innerText.trim()}`;
        }
    }

    function updateStrengthBars(score) {
        const bars = [
            document.getElementById('bar1'),
            document.getElementById('bar2'),
            document.getElementById('bar3'),
            document.getElementById('bar4')
        ];
        
        // Colores correspondientes
        const colors = ['#ef4444', '#f59e0b', '#3b82f6', '#10b981']; // rojo, naranja, azul, verde

        bars.forEach((bar, idx) => {
            if (!bar) return;
            if (idx < score) {
                bar.style.backgroundColor = colors[score - 1];
            } else {
                bar.style.backgroundColor = '#eee';
            }
        });
    }

    form.addEventListener('submit', (e) => {
        let isValid = true;

        const passwordVal = passwordInput.value;
        const hasLength = passwordVal.length >= 8;
        const hasUpper = /[A-Z]/.test(passwordVal);
        const hasLower = /[a-z]/.test(passwordVal);
        const hasNumber = /[0-9]/.test(passwordVal);
        const hasSpecial = /[@$!%*?&_#\-\+\(\)\[\]\{\}\.\,\:\;\/\=\?\|]/.test(passwordVal);

        if (!passwordVal) {
            showError(passwordInput, 'La contraseña es obligatoria.');
            isValid = false;
        } else if (!(hasLength && hasUpper && hasLower && hasNumber && hasSpecial)) {
            showError(passwordInput, 'La contraseña debe ser segura y cumplir con todos los requisitos en verde.');
            isValid = false;
        } else {
            clearError(passwordInput);
        }

        if (!confirmInput.value) {
            showError(confirmInput, 'Por favor, confirma tu contraseña.');
            isValid = false;
        } else if (confirmInput.value !== passwordVal) {
            showError(confirmInput, 'Las contraseñas no coinciden.');
            isValid = false;
        } else {
            clearError(confirmInput);
        }

        if (!isValid) {
            e.preventDefault();
        }
    });
});
</script>
@endpush
