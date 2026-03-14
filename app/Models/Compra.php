<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $fillable = [
        'fecha',
        'comprobante',
        'precio_final',
        'proveedor_id',
        'activo'
    ];

    use HasFactory;

    public function detalles()
    {
        return $this->hasMany(DetalleCompra::class);
    }
    public function proveedor()
    {

        return $this->belongsTo(Proveedor::class);
    }
    public function productos()
    {
        return $this->belongsToMany(
            Producto::class,
            'detalle_compras'
        )
            ->withPivot('cantidad', 'precio_compra')
            ->withTimestamps();
    }
}
