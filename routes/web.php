<?php

use App\Http\Controllers\InventarioController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReporteController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Página principal
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Aviso de Privacidad
Route::get('/privacy/integral', function () {
    return view('privacy.integral');
})->name('privacy.integral');

// WEB SERVICES - CONSUMO Y PROVISIÓN
use App\Http\Controllers\ApiExternaController;
use App\Http\Controllers\Api\InventarioController as ApiInventarioController;

Route::get('/precios-externos', [ApiExternaController::class, 'preciosMercado'])
    ->name('precios.externos');

// API QUE TU PROYECTO PROVEE
Route::get('/api/inventario', [ApiInventario::class, 'index']);
Route::get('/api/inventario/stock-bajo', [ApiInventario::class, 'stockBajo']);
Route::post('/api/inventario/entrada', [ApiInventario::class, 'entrada']);

// REPORTE SEMANAL
Route::get('/reportes/semanal', [ReporteController::class, 'semanal'])
    ->name('reportes.semanal')
    ->middleware('auth');

// RUTAS ADMIN USUARIOS
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::resource('usuarios', UserController::class)->parameters([
        'usuarios' => 'user'
    ]);

    Route::post('usuarios/{user}/activate', [UserController::class, 'activate'])
        ->name('usuarios.activate');

    Route::post('usuarios/{user}/permiso', [UserController::class, 'otorgarPermiso'])
        ->name('usuarios.permiso');

    Route::post('usuarios/{user}/toggle', [UserController::class, 'toggleSuspend'])
        ->name('usuarios.toggle');
});

// Inventario
Route::resource('inventario', InventarioController::class)->only(['index', 'store']);
Route::post('inventario/{producto}/salida', [InventarioController::class, 'salida'])
    ->name('inventario.salida');