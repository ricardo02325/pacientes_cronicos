<?php

use App\Models\TotalPacientes;
use App\Models\TotalPacientesRiesgoAlto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PacientesController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\DoctorController;

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

Route::get('/pacientes', [PacientesController::class, 'index'])
    ->name('admin.pacientes');

// Rutas para gestión de médicos
Route::get('/medicos', [DoctorController::class, 'index'])
    ->name('admin.medicos');

Route::put('/usuarios/{id}/estado', [UsuarioController::class, 'cambiarEstado']);

Route::post('/medicos/registrar', [DoctorController::class, 'store'])
    ->name('medicos.store');