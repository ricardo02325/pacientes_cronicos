@extends('admin.layouts.app')

@section('title', 'Dashboard General')

@push('styles')
    @vite(['resources/css/admin/pacientes.css', 'resources/css/admin/dashboard.css'])
@endpush

@section('content')

    <!-- Banner de bienvenida -->
    <div class="patients-header-container" style="margin-bottom: 24px;">
        <div class="patients-title-group">
            <h1 class="page-main-heading">Panel de Control Clínico</h1>
            <p class="page-sub-heading">
                Resumen ejecutivo del sistema de monitoreo de pacientes crónicos • {{ now()->translatedFormat('d \d\e F, Y') }}
            </p>
        </div>

        <div class="patients-header-actions">
            <a href="{{ route('admin.pacientes') }}" class="btn-primary">
                <i class="fa-solid fa-hospital-user"></i>
                <span>Gestionar Pacientes</span>
            </a>
        </div>
    </div>

    @include('admin.partials.dashboard.stats')

    <div class="dashboard-main-grid">
        <div class="grid-table-area">
            @include('admin.partials.dashboard.table')
        </div>
        <div class="grid-chart-area">
            @include('admin.partials.dashboard.chart')
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        window.condicionesChart = @json($condiciones ?? []);
    </script>
    @vite('resources/js/admin/dashboard.js')
@endpush
