<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'numero_documento',
        'telefono',
        'email'
    ];

    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }
}
