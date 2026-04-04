<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    protected $fillable = [
        'nombre_empresa',
        'direccion',
        'telefono',
        'email',
        'descripcion',
        'cuit',
        'cuidad',
        'logo',
        'imagen_login',
        'imprimir_ticket',
    ];
}
