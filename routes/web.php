<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DoctorController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PacientesController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\ProfileController;

require __DIR__.'/auth.php';

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/admin', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('/pacientes', [PacientesController::class, 'index'])
        ->name('admin.pacientes');

    Route::post('/pacientes', [PacientesController::class, 'store'])
        ->name('pacientes.store');

    Route::get('/medicos', [DoctorController::class, 'index'])
        ->name('admin.medicos');

    Route::post('/medicos/registrar', [DoctorController::class, 'store'])
        ->name('medicos.store');

    Route::put('/usuarios/{id}/estado', [UsuarioController::class, 'cambiarEstado']);

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

Route::prefix('medico')
    ->name('medico.')
    ->middleware('auth')
    ->group(function () {

        Route::get('/', function () {
            return redirect()->route('medico.pacientes.index');
        })->name('dashboard');

        Route::get('/pacientes', [PacienteController::class, 'index'])
            ->name('pacientes.index');

        Route::get('/pacientes/{id}', [PacienteController::class, 'show'])
            ->name('pacientes.show');

        Route::get('/pacientes/{id}/exportar-pdf', [PacienteController::class, 'exportPDF'])
            ->name('pacientes.exportPdf');

        Route::get('/reportes', function () {
            return view('medico.reportes');
        })->name('reportes');
});

Route::fallback(function () {
    return redirect()->route('login');
});