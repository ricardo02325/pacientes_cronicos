@extends('admin.layouts.app')

@section('title', 'Cuerpo Médico')

@push('styles')
    @vite(['resources/css/admin/pacientes.css', 'resources/css/admin/medicos.css'])
@endpush

@section('content')

    @include('admin.partials.medicos.header')

    @include('admin.partials.medicos.stats')

    @include('admin.partials.medicos.grid')

    @include('admin.partials.medicos.modal')

    @include('admin.partials.medicos.modal_editar')

    @include('admin.partials.medicos.modal_eliminar')

@endsection

@push('scripts')
    @vite('resources/js/admin/medicos.js')
@endpush