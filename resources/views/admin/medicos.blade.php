@extends('admin.layouts.app')

@section('title', 'Médicos')

@push('styles')
    @vite(['resources/css/admin/medicos.css'])
@endpush

@section('content')

    @include('admin.partials.medicos.header')

    @include('admin.partials.medicos.grid')

    @include('admin.partials.medicos.modal')

@endsection

@push('scripts')
    @vite('resources/js/admin/medicos.js')
@endpush