@extends('medico.layouts.app')

@section('title', 'Mis Pacientes')

@push('styles')
    @vite('resources/css/medico/pacientes.css')
@endpush

@section('content')

    @include('medico.partials.pacientes.header')

    @include('medico.partials.pacientes.stats')

    @include('medico.partials.pacientes.filters')

    @include('medico.partials.pacientes.table')

@endsection