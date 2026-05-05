@extends('admin.layouts.app')

@section('title', 'Dashboard')

@push('styles')
    @vite('resources/css/admin/dashboard.css')
@endpush

@section('content')

    @include('admin.partials.dashboard.stats')

    <div class="content-grid">
        @include('admin.partials.dashboard.table')
        @include('admin.partials.dashboard.chart')
    </div>

@endsection