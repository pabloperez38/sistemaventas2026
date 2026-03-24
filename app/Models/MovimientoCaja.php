<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimientoCaja extends Model
{
    protected $fillable = [
        'monto',
        'descripcion',
        'tipo',
        'caja_id'
    ];

    use HasFactory;

    public function caja()
    {
        return $this->belongsTo(Caja::class);
    }
}
