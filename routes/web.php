<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DoctorController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PacientesController;

Route::get('/', [DashboardController::class, 'index'])
    ->name('admin.dashboard');

Route::get('/pacientes', [PacientesController::class, 'index'])
    ->name('admin.pacientes');

Route::post('/pacientes', [PacientesController::class, 'store'])
    ->name('pacientes.store');

Route::get('/medicos', [DoctorController::class, 'index'])
    ->name('admin.medicos');

Route::put('/usuarios/{id}/estado', [UsuarioController::class, 'cambiarEstado']);

Route::post('/medicos/registrar', [DoctorController::class, 'store'])
    ->name('medicos.store');