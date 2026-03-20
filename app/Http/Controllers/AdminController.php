<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Producto;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function index()
    {
        $total_roles = Role::count();
        $total_usuarios = User::count();
        $total_categorias = Categoria::count();
        $total_marcas = Marca::count();
        $total_productos = Producto::count();

        return view('admin.index', compact('total_roles', 'total_usuarios', 'total_categorias', 'total_marcas', 'total_productos'));
    }
}
