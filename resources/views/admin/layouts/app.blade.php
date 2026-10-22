<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CroniCare') — Panel de Control</title>

    <!-- Fuentes e Iconos -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- VITE CSS y JS Base --}}
    @vite(['resources/css/admin/app.css', 'resources/js/admin/app.js'])
    @stack('styles')
</head>

<body>

    @include('admin.partials.sidebar')

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
                        <strong>Error</strong>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button type="button" class="toast-close" onclick="this.parentElement.remove()">&times;</button>
                </div>
            @endif

            @if($errors->any())
                <div class="toast-alert toast-danger" role="alert">
                    <div class="toast-icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
                    <div class="toast-body">
                        <strong>Por favor verifica los siguientes campos:</strong>
                        <ul style="margin: 4px 0 0 16px; padding: 0; font-size: 13px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="toast-close" onclick="this.parentElement.remove()">&times;</button>
                </div>
            @endif
        </div>

        @yield('content')
    </main>

    @stack('scripts')

    <script>
        // Auto-desvanecer los toasts tras 5 segundos
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