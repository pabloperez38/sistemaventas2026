<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use SoftDeletes, HasFactory;

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
