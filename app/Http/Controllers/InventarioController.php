<?php
namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class InventarioController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $user = auth()->user();
        if (!$user->puede_ver_inventario && !$user->esAdmin()) {
            abort(403, 'No tienes permiso para ver el inventario. Contacta al administrador.');
        }

        $productos = Producto::all();
        $alertas = $productos->filter->stockBajo();
        return view('inventario.index', compact('productos', 'alertas'));
    }

    public function store(Request $request) { // Entrada
        $request->validate(['nombre' => 'required', 'cantidad' => 'required|integer|min:1']);
        $producto = Producto::updateOrCreate(['nombre' => $request->nombre], ['stock' => $request->stock + $request->cantidad]);
        return redirect()->route('inventario.index')->with('success', 'Entrada registrada.');
    }

    public function salida(Request $request, Producto $producto) {
        if ($producto->stock < $request->cantidad) {
            return back()->withErrors(['cantidad' => 'Stock insuficiente.']);
        }
        $producto->decrement('stock', $request->cantidad);
        return redirect()->route('inventario.index')->with('success', 'Salida registrada.');
    }
}