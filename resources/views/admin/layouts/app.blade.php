<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CróniCare')</title>

    <!-- Fuentes e Iconos -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- VITE --}}
    @vite(['resources/js/admin/app.js'])
    @stack('styles')
</head>

<body>

    @include('admin.partials.sidebar')

    <main class="main-content">
        @yield('content')
    </main>
</body>
@stack('scripts')
</html>