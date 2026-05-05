@extends('admin.layouts.app')

@section('title', 'Citas')

@push('styles')
    @vite('resources/css/admin/app.css')
@endpush

@section('content')

    @include('admin.partials.header')

    @include('admin.partials.stats')

    @include('admin.partials.filters')

    @include('admin.partials.appointments')

@endsection