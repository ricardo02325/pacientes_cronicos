<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MedicoApiController;
use App\Http\Controllers\Api\MetricaApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - Sistema de Monitoreo de Pacientes Crónicos (v1)
|--------------------------------------------------------------------------
| Endpoints RESTful para la Aplicación Móvil y consumo externo.
*/

Route::prefix('v1')->group(function () {

    // ==========================================
    // Rutas Públicas (Sin Token)
    // ==========================================
    Route::prefix('auth')->group(function () {
        // Auto-registro del paciente desde la app móvil
        Route::post('/register-paciente', [AuthController::class, 'registerPaciente']);
        // Inicio de sesión móvil
        Route::post('/login', [AuthController::class, 'login']);
    });

    // Catálogos públicos requeridos para registro móvil
    Route::get('/catalogos/metricas', [MetricaApiController::class, 'catalogo']);
    Route::get('/catalogos/medicos', [MedicoApiController::class, 'index']);

    // ==========================================
    // Rutas Protegidas (Requieren Bearer Token Sanctum)
    // ==========================================
    Route::middleware('auth:sanctum')->group(function () {

        // Sesión y Perfil
        Route::prefix('auth')->group(function () {
            Route::get('/me', [AuthController::class, 'me']);
            Route::post('/logout', [AuthController::class, 'logout']);
        });

        // Métricas de Salud (RF-04, RF-06, RF-08)
        Route::prefix('metricas')->group(function () {
            // Historial con filtros (fecha_inicio, fecha_fin, tipo_metrica_id)
            Route::get('/', [MetricaApiController::class, 'index']);
            // Registrar una nueva métrica (presión, glucosa, etc.)
            Route::post('/', [MetricaApiController::class, 'store']);
            // Resumen de últimas métricas para widgets/dashboard móvil
            Route::get('/resumen-dashboard', [MetricaApiController::class, 'resumenDashboard']);
        });

    });

});
