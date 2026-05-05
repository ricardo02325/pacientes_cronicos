@extends('admin.layouts.app')

@section('title', 'Pacientes')

@push('styles')
    @vite('resources/css/admin/pacientes.css')
@endpush

@section('content')

    @include('admin.partials.pacientes.header')

    @include('admin.partials.pacientes.table')

    @include('admin.partials.pacientes.modal')

@endsection

@push('scripts')
    @vite('resources/js/admin/pacientes.js')
@endpush