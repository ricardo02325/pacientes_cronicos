<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CróniCare Médico')</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- VITE (Ajusta la ruta de tus assets si es necesario) --}}
    @vite(['resources/css/medico/app.css'])
    @stack('styles')
</head>
<body>

    @include('medico.partials.sidebar')

    <main class="main-content">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>