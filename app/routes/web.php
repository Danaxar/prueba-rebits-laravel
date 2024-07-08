<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\HistoricoController;
use Inertia\Inertia;

// API
Route::prefix('api')->group(function () {
    // Usuarios
    Route::prefix('usuarios')->group(function () {
        Route::get('/', [UsuariosController::class, 'getAll']);
    });

    // Vehiculos
    Route::prefix('vehiculos')->group(function () {
        Route::get('/', [VehiculoController::class, 'getAll']);
        Route::get('/{id}/getDueno', [VehiculoController::class, 'getDueno']);
        Route::get('/{id}', [VehiculoController::class, 'getById']);
        Route::put('/{id}', [VehiculoController::class, 'update']);
        Route::post('/nuevoDueno', [VehiculoController::class, 'nuevoDueno']);
    });

    // Excel
    Route::prefix('excel')->group(function () {
        Route::post('/upload', [ExcelController::class, 'upload']);
    });

    // Historicos
    Route::prefix('historicos')->group(function () {
        Route::get('/', [HistoricoController::class, 'getAll']);
    });
});

// Inertia
Route::get('/', function () {
    return Inertia::render('Home');
});
Route::get('/vehiculos', function () {
    return Inertia::render('VehiculosPage');
});
Route::get('/usuarios', function () {
    return Inertia::render('UsuariosPage');
});
Route::get('/historicos', function () {
    return Inertia::render('HistoricosPage');
});
Route::get('/editar-vehiculo/{id}', function () {
    return Inertia::render('EditarVehiculoPage');
});
