<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientoCajaMetodo extends Model
{
    protected $table = 'movimiento_caja_metodos';

    protected $fillable = [
        'movimiento_caja_id',
        'metodo_pago_id',
        'monto'
    ];

    public function movimientoCaja()
    {
        return $this->belongsTo(MovimientoCaja::class);
    }

    public function metodoPago()
    {
        return $this->belongsTo(MetodoPago::class);
    }
}
