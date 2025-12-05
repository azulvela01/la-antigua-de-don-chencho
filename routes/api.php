<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\InventarioController;
use App\Http\Controllers\ApiExternaController;

// TUS ENDPOINTS QUE PROVEE EL SISTEMA
Route::get('/inventario', [InventarioController::class, 'index']);
Route::get('/inventario/stock-bajo', [InventarioController::class, 'stockBajo']);
Route::post('/inventario/entrada', [InventarioController::class, 'entrada']);

// CONSUMO DE API EXTERNA (con fallback si datos.gob.mx falla)
Route::get('/precios-externos', [ApiExternaController::class, 'preciosMercado']);