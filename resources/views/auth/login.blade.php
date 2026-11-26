<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Iniciar Sesión — CroniCare</title>

    <!-- Fuentes e Iconos -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Estilos de Login CroniCare -->
    @vite(['resources/css/auth/login.css'])
</head>
<body class="login-body">

    <div class="login-wrapper">
        <div class="login-card">

            <!-- Encabezado y Logo CroniCare -->
            <div class="brand-header">
                <div class="brand-icon">
                    <i class="fa-solid fa-heart-pulse"></i>
                </div>
                <h1 class="brand-title">CroniCare</h1>
                <p class="brand-subtitle">Sistema de Monitoreo de Pacientes Crónicos</p>
                <div>
                    <span class="portal-badge">
                        <i class="fa-solid fa-shield-halved"></i> Acceso Seguro
                    </span>
                </div>
            </div>

            <!-- Notificación de estado de sesión -->
            @if (session('status'))
                <div class="status-box">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <!-- Notificación de errores generales -->
            @if ($errors->any())
                <div class="alert-box">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span>Por favor verifica tus credenciales para continuar.</span>
                </div>
            @endif

            <!-- Formulario de autenticación -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Correo Electrónico -->
                <div class="form-group">
                    <label class="form-label" for="email">
                        <i class="fa-regular fa-envelope"></i> Correo Electrónico
                    </label>
                    <div class="input-container">
                        <i class="fa-solid fa-at input-icon-left"></i>
                        <input 
                            id="email" 
                            class="form-input" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            placeholder="usuario@CroniCare.com"
                            required 
                            autofocus 
                            autocomplete="username" 
                        />
                    </div>
                    @error('email')
                        <div class="error-message">
                            <i class="fa-solid fa-circle-xmark"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Contraseña -->
                <div class="form-group">
                    <label class="form-label" for="password">
                        <i class="fa-solid fa-lock"></i> Contraseña
                    </label>
                    <div class="input-container">
                        <i class="fa-solid fa-key input-icon-left"></i>
                        <input 
                            id="password" 
                            class="form-input" 
                            type="password" 
                            name="password" 
                            placeholder="••••••••"
                            required 
                            autocomplete="current-password" 
                        />
                        <button type="button" class="input-btn-toggle" id="togglePasswordBtn" title="Mostrar/Ocultar contraseña">
                            <i class="fa-regular fa-eye" id="togglePasswordIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="error-message">
                            <i class="fa-solid fa-circle-xmark"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Recordar sesión y Olvido de contraseña -->
                <div class="form-options">
                    <label for="remember_me" class="remember-check">
                        <input id="remember_me" type="checkbox" name="remember">
                        <span>Recordar sesión</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="forgot-link" href="{{ route('password.request') }}">
                            ¿Olvidaste tu contraseña?
                        </a>
                    @endif
                </div>

                <!-- Botón de Envío -->
                <button type="submit" class="btn-submit">
                    <span>Ingresar al Sistema</span>
                    <i class="fa-solid fa-arrow-right-to-bracket"></i>
                </button>
            </form>

            <!-- Footer Informativo con accesos directos para pruebas -->
            <div class="login-footer">
                <div class="footer-roles">
                    <button type="button" class="role-pill" id="fillAdminBtn" style="border:none; cursor:pointer;" title="Rellenar credenciales de Administrador">
                        <i class="fa-solid fa-user-shield"></i> Administrador demo
                    </button>
                    <button type="button" class="role-pill" id="fillMedicoBtn" style="border:none; cursor:pointer;" title="Rellenar credenciales de Médico">
                        <i class="fa-solid fa-user-doctor"></i> Médico demo
                    </button>
                </div>
                <p class="footer-hint">
                    Haz clic en cualquiera de los roles para autocompletar las credenciales de prueba.
                </p>
            </div>

        </div>
    </div>

    <!-- Script para visibilidad de contraseña y autocompletado demo -->
    <script>
        const toggleBtn = document.getElementById('togglePasswordBtn');
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('togglePasswordIcon');

        if (toggleBtn && passwordInput && toggleIcon) {
            toggleBtn.addEventListener('click', function () {
                const isPassword = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                toggleIcon.classList.toggle('fa-eye', !isPassword);
                toggleIcon.classList.toggle('fa-eye-slash', isPassword);
            });
        }

        // Acceso rápido para pruebas de tesis
        const fillAdminBtn = document.getElementById('fillAdminBtn');
        const fillMedicoBtn = document.getElementById('fillMedicoBtn');

        if (fillAdminBtn && emailInput && passwordInput) {
            fillAdminBtn.addEventListener('click', () => {
                emailInput.value = 'admin@CroniCare.com';
                passwordInput.value = 'admin123';
                emailInput.focus();
            });
        }

        if (fillMedicoBtn && emailInput && passwordInput) {
            fillMedicoBtn.addEventListener('click', () => {
                emailInput.value = 'medico@CroniCare.com';
                passwordInput.value = 'medico123';
                emailInput.focus();
            });
        }
    </script>
</body>
</html>
