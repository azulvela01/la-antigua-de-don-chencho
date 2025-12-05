<?php

namespace App\Http\Controllers;

use App\Models\MovimientoInventario;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function semanal()
    {
        $inicio = now()->startOfWeek();
        $fin = now()->endOfWeek();

        $movimientos = MovimientoInventario::with(['producto', 'user'])
            ->whereBetween('created_at', [$inicio, $fin])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('reportes.semanal', compact('movimientos', 'inicio', 'fin'));
    }
}