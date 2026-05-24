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

Route::prefix('medico')->name('medico.')->group(function () {
    
    // 1. Dashboard Principal / Inicio
    // Actúa como el "home" redirigiendo directamente a la vista de pacientes
    Route::get('/', function () {
        return redirect()->route('medico.pacientes.index'); 
    })->name('dashboard');

    // 2. Listado de "Mis Pacientes"
    // Conectado al controlador para traer estadísticas y listado real
    Route::get('/pacientes', [PacienteController::class, 'index'])->name('pacientes.index');

    // 3. Monitoreo de un Paciente Específico
    Route::get('/pacientes/{id}', [PacienteController::class, 'show'])->name('pacientes.show');

    Route::get('/pacientes/{id}/exportar-pdf', [PacienteController::class, 'exportPDF'])->name('pacientes.exportPdf');

    // 4. Reportes (Placeholder para futuro desarrollo)
    Route::get('/reportes', function () {
        return view('medico.reportes');
    })->name('reportes');

})
;