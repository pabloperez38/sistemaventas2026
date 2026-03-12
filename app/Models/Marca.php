<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Marca extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre'
    ];

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }

    protected static function booted()
    {
        static::deleting(function ($marca) {

            $marca->activo = 0;
            $marca->save();

            foreach ($marca->productos()->get() as $producto) {
                $producto->activo = 0;
                $producto->save();
                $producto->delete();
            }
        });

        static::restoring(function ($marca) {

            $marca->activo = 1;
            $marca->save();

            foreach ($marca->productos()->withTrashed()->get() as $producto) {
                $producto->restore();
                $producto->activo = 1;
                $producto->save();
            }
        });
    }
}
