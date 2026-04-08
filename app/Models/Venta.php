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
        'activo',
        'caja_id',
        'user_id'
    ];

    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function cliente()
    {

        return $this->belongsTo(Cliente::class);
    }
    public function caja()
    {
        return $this->belongsTo(Caja::class);
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
    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }
}
