<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TmpCompra extends Model
{
    protected $fillable = [
        'producto_id',
        'cantidad',
        'session_id'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
