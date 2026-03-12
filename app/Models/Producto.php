<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'precio_compra',
        'precio_venta',
        'stock',
        'stock_minimo',
        'estado',
        'codigo',
        'categoria_id',
        'marca_id'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class)->withTrashed();
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class)->withTrashed();
    }
}
