<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;

class InventarioController extends Controller
{
    public function index()
    {
        $productos = Producto::select('id', 'nombre', 'stock', 'precio_compra', 'updated_at')->get();

        return response()->json([
            'success' => true,
            'total' => $productos->count(),
            'data' => $productos
        ]);
    }

    public function stockBajo()
    {
        $productos = Producto::where('stock', '<=', 10)->get();

        return response()->json([
            'success' => true,
            'alerta' => 'Productos con stock bajo (≤10)',
            'total' => $productos->count(),
            'data' => $productos
        ]);
    }
}