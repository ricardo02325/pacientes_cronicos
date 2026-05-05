<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::get('/pacientes', function () {
    return view('admin.pacientes');
})->name('admin.pacientes');

Route::get('/medicos', function () {
    return view('admin.medicos');
})->name('admin.medicos');

Route::get('/citas', function () {
    return view('admin.citas');
})->name('admin.citas');