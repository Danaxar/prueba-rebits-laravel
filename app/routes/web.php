<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\ExcelController;
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
    });

    // Excel
    // Route::prefix('excel')->group(function () {
    //     Route::post('/upload', [ExcelController::class, 'upload']);
    // });
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
