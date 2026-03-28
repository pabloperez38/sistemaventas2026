<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MovimientoCajaMetodo;

class MovimientoCaja extends Model
{
    protected $fillable = [
        'monto',
        'descripcion',
        'tipo',
        'caja_id',
        'metodo_pago_id'
    ];

    use HasFactory;

    public function caja()
    {
        return $this->belongsTo(Caja::class);
    }

    public function metodosPago()
    {
        return $this->hasMany(MovimientoCajaMetodo::class);
    }
}
