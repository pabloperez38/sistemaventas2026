<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Venta extends Model
{
     use HasFactory;

    protected $fillable = [
        'fecha',     
        'precio_final',
        'cliente_id',
        'activo'
    ];   

    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class);
    }
    public function cliente()
    {

        return $this->belongsTo(Cliente::class);
    }
    public function productos()
    {
        return $this->belongsToMany(
            Producto::class,
            'detalle_ventas'
        )
            ->withPivot('cantidad', 'precio_venta')
            ->withTimestamps();
    }
}
