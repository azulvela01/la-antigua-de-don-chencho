<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model {
    use HasFactory;

    protected $fillable = ['nombre', 'stock', 'precio_compra', 'descripcion'];

    // Alerta de stock bajo
    public function stockBajo(): bool {
        return $this->stock < 10;
    }
}