<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DoctorController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PacientesController;
use App\Http\Controllers\Medico\PacienteController;
use App\Http\Controllers\Paciente\DashboardController as PacienteDashboardController;

require __DIR__.'/auth.php';

Route::get('/', function () {
    return redirect()->route('login');
});

// =========================================
// RUTAS DE ADMINISTRADOR (rol_id = 1)
// =========================================
Route::middleware(['auth', 'role:1'])->group(function () {

    Route::get('/admin', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    // CRUD Pacientes
    Route::get('/pacientes', [PacientesController::class, 'index'])
        ->name('admin.pacientes');
    Route::post('/pacientes', [PacientesController::class, 'store'])
        ->name('pacientes.store');
    Route::get('/pacientes/{id}', [PacientesController::class, 'show'])
        ->name('pacientes.show');
    Route::put('/pacientes/{id}', [PacientesController::class, 'update'])
        ->name('pacientes.update');
    Route::delete('/pacientes/{id}', [PacientesController::class, 'destroy'])
        ->name('pacientes.destroy');

    // CRUD Médicos
    Route::get('/medicos', [DoctorController::class, 'index'])
        ->name('admin.medicos');
    Route::post('/medicos/registrar', [DoctorController::class, 'store'])
        ->name('medicos.store');
    Route::get('/medicos/{id}', [DoctorController::class, 'show'])
        ->name('medicos.show');
    Route::put('/medicos/{id}', [DoctorController::class, 'update'])
        ->name('medicos.update');
    Route::delete('/medicos/{id}', [DoctorController::class, 'destroy'])
        ->name('medicos.destroy');

    // Cambio rápido de estado
    Route::put('/usuarios/{id}/estado', [UsuarioController::class, 'cambiarEstado'])
        ->name('usuarios.cambiarEstado');
});

// =========================================
// RUTAS DE MÉDICO (rol_id = 2)
// =========================================
Route::prefix('medico')
    ->name('medico.')
    ->middleware(['auth', 'role:2'])
    ->group(function () {

        Route::get('/', function () {
            return redirect()->route('medico.pacientes.index');
        })->name('dashboard');

        Route::get('/pacientes', [PacienteController::class, 'index'])
            ->name('pacientes.index');

        Route::get('/pacientes/{id}', [PacienteController::class, 'show'])
            ->name('pacientes.show');

        // Registrar métrica desde el monitoreo del médico
        Route::post('/pacientes/{id}/metricas', [PacienteController::class, 'storeMetrica'])
            ->name('pacientes.storeMetrica');

        Route::get('/pacientes/{id}/exportar-pdf', [PacienteController::class, 'exportPDF'])
            ->name('pacientes.exportPdf');

        Route::get('/reportes', [PacienteController::class, 'reportes'])
            ->name('reportes');
});

// =========================================
// RUTAS DE PACIENTE (rol_id = 3)
// =========================================
Route::prefix('paciente')
    ->name('paciente.')
    ->middleware(['auth', 'role:3'])
    ->group(function () {

        Route::get('/', [PacienteDashboardController::class, 'index'])
            ->name('dashboard');

        Route::post('/metricas', [PacienteDashboardController::class, 'storeMetrica'])
            ->name('metricas.store');

        Route::get('/historial', [PacienteDashboardController::class, 'historial'])
            ->name('historial');
});

// =========================================
// FALLBACK: cualquier ruta no definida → login
// =========================================
Route::fallback(function () {
    return redirect()->route('login');
});