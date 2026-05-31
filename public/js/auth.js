document.addEventListener('DOMContentLoaded', () => {
    // ----------------------------------------------------
    // CONSTANTES Y SELECTORES
    // ----------------------------------------------------
    const formLogin = document.getElementById('formLogin') || document.querySelector('form[action*="login"]');
    const formRegister = document.getElementById('formRegister') || document.querySelector('form[action*="register"]');

    // Regex para validar formato de correo electrónico
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // ----------------------------------------------------
    // FUNCIONES DE UTILIDAD (MARK & CLEAN ERRORS)
    // ----------------------------------------------------
    function showError(inputElement, message) {
        // Evitar duplicados
        clearError(inputElement);
        
        // Marcar input con la clase inválido
        inputElement.classList.add('invalido');
        
        // Crear el elemento de feedback
        const errorDiv = document.createElement('div');
        errorDiv.className = 'errorFeedback';
        errorDiv.innerHTML = `<i class="fa-solid fa-circle-exclamation"></i> <span>${message}</span>`;
        
        // Insertarlo justo después del wrapper si existe, o del input
        const wrapper = inputElement.closest('.posicionadorContrasena');
        if (wrapper) {
            wrapper.parentNode.appendChild(errorDiv);
        } else {
            inputElement.parentNode.appendChild(errorDiv);
        }
    }

    function clearError(inputElement) {
        inputElement.classList.remove('invalido');
        const wrapper = inputElement.closest('.posicionadorContrasena');
        const parent = wrapper ? wrapper.parentNode : inputElement.parentNode;
        const feedback = parent.querySelector('.errorFeedback');
        if (feedback) {
            parent.removeChild(feedback);
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

    // ----------------------------------------------------
    // VALIDACIÓN DE FORMULARIO DE INICIO DE SESIÓN (LOGIN)
    // ----------------------------------------------------
    if (formLogin) {
        formLogin.addEventListener('submit', (e) => {
            let isValid = true;
            
            const emailInput = formLogin.querySelector('#email');
            const passwordInput = formLogin.querySelector('#password');
            
            // Validar Email
            if (!emailInput.value.trim()) {
                showError(emailInput, 'El correo electrónico es obligatorio.');
                isValid = false;
            } else if (!emailRegex.test(emailInput.value.trim())) {
                showError(emailInput, 'El correo electrónico no es válido.');
                isValid = false;
            } else {
                clearError(emailInput);
            }
            
            // Validar Contraseña
            if (!passwordInput.value) {
                showError(passwordInput, 'La contraseña es obligatoria.');
                isValid = false;
            } else {
                clearError(passwordInput);
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });
    }

    // ----------------------------------------------------
    // VALIDACIÓN DE FORMULARIO DE REGISTRO
    // ----------------------------------------------------
    if (formRegister) {
        const nameInput = formRegister.querySelector('#name');
        const emailInput = formRegister.querySelector('#email');
        const passwordInput = formRegister.querySelector('#password');
        const confirmInput = formRegister.querySelector('#password_confirmation');

        // Crear elementos visuales premium de fuerza de contraseña e información
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
            const targetParent = passwordInput.closest('.posicionadorContrasena') ? passwordInput.closest('.posicionadorContrasena').parentNode : passwordInput.parentNode;
            targetParent.appendChild(strengthMeter);

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
            targetParent.appendChild(reqInfo);

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

        formRegister.addEventListener('submit', (e) => {
            let isValid = true;

            // Validar Nombre
            if (!nameInput.value.trim()) {
                showError(nameInput, 'El nombre completo es obligatorio.');
                isValid = false;
            } else {
                clearError(nameInput);
            }

            // Validar Email
            if (!emailInput.value.trim()) {
                showError(emailInput, 'El correo electrónico es obligatorio.');
                isValid = false;
            } else if (!emailRegex.test(emailInput.value.trim())) {
                showError(emailInput, 'El correo electrónico no es válido.');
                isValid = false;
            } else {
                clearError(emailInput);
            }

            // Validar Contraseña Segura
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

            // Validar Confirmación de Contraseña
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
    }

    // ----------------------------------------------------
    // TOGGLE VISIBILIDAD DE CONTRASEÑA
    // ----------------------------------------------------
    document.querySelectorAll('.btn-toggle-password').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const wrapper = btn.closest('.posicionadorContrasena');
            if (!wrapper) return;
            const input = wrapper.querySelector('input');
            const icon = btn.querySelector('i');
            if (input && icon) {
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                    btn.setAttribute('aria-label', 'Ocultar contraseña');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                    btn.setAttribute('aria-label', 'Mostrar contraseña');
                }
            }
        });
    });
});

