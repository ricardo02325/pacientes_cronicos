<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CroniCare') — Portal Médico</title>

    <!-- Fuentes e Iconos -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- VITE CSS --}}
    @vite(['resources/css/medico/app.css'])
    @stack('styles')
</head>

<body>

    @include('medico.partials.sidebar')

    <main class="main-content">
        <!-- Notificaciones Flotantes (Toasts) -->
        <div class="toast-container" id="toastContainer">
            @if(session('success'))
                <div class="toast-alert toast-success" role="alert">
                    <div class="toast-icon"><i class="fa-solid fa-circle-check"></i></div>
                    <div class="toast-body">
                        <strong>¡Éxito!</strong>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" class="toast-close" onclick="this.parentElement.remove()">&times;</button>
                </div>
            @endif

            @if(session('error'))
                <div class="toast-alert toast-danger" role="alert">
                    <div class="toast-icon"><i class="fa-solid fa-circle-exclamation"></i></div>
                    <div class="toast-body">
                        <strong>Atención</strong>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button type="button" class="toast-close" onclick="this.parentElement.remove()">&times;</button>
                </div>
            @endif
        </div>

        @yield('content')
    </main>

    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toasts = document.querySelectorAll('.toast-alert');
            toasts.forEach(t => {
                setTimeout(() => {
                    t.style.opacity = '0';
                    t.style.transform = 'translateX(20px)';
                    setTimeout(() => t.remove(), 300);
                }, 5000);
            });
        });
    </script>
</body>
</html>