<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha_apertura',
        'monto_inicial',
        'descripcion',
        'fecha_cierre',
        'monto_final',
        'activo'
    ];

    protected $casts = [
        'fecha_apertura' => 'datetime',
        'fecha_cierre' => 'datetime'

    ];

    public function movimientos()
    {

        return $this->hasMany(MovimientoCaja::class);
    }
    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }

    public function compras()
    {
        return $this->hasMany(Compra::class);
    }
}
