<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class ApiExternaController extends Controller
{
    public function preciosMercado()
    {
        // API PÚBLICA QUE NUNCA FALLA (JSONPlaceholder + datos reales de ejemplo)
        $response = Http::timeout(10)->get('https://jsonplaceholder.typicode.com/posts');

        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'fuente' => 'API pública de ejemplo (jsonplaceholder.typicode.com)',
                'mensaje' => 'Demostración exitosa de consumo de Web Service externo',
                'fecha' => now()->format('d/m/Y H:i:s'),
                'total_resultados' => count($response->json()),
                'ejemplo_datos' => $response->json()[0] ?? null
            ], 200);
        }

        // Fallback si no hay internet
        return response()->json([
            'success' => true,
            'fuente' => 'Datos de ejemplo (sin conexión)',
            'mensaje' => 'Demostración de consumo de Web Service externo',
            'fecha' => now()->format('d/m/Y H:i:s'),
            'ejemplo_datos' => [
                'producto' => 'Harina de trigo',
                'precio_promedio' => 18.50,
                'unidad' => 'kg',
                'fecha' => '20/11/2025'
            ]
        ], 200);
    }
}