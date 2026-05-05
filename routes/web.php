<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\TotalPacientes;
use App\Models\TotalPacientesRiesgoAlto;

Route::get('/', function () {
    $totalPacientes = TotalPacientes::value('total');
    $riesgoAlto = TotalPacientesRiesgoAlto::value('total');

    $pacientesEstado = DB::table('pacientes_estado')->get();

    return view('admin.dashboard', compact(
        'totalPacientes',
        'riesgoAlto',
        'pacientesEstado'
    ));
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