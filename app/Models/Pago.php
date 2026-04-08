<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $fillable = ['venta_id', 'metodo', 'monto', 'metodo_pago_id',];

    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }
    public function metodoPago()
    {
        return $this->belongsTo(MetodoPago::class);
    }
}
