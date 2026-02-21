<?php

namespace App\Http\Controllers;

use App\Models\Configuracion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ConfiguracionController extends Controller
{
    public function index()
    {
        $configuracion = Configuracion::first();
        return view('admin.configuracion.index', compact('configuracion'));
    }

    public function update(Request $request)
    {
        //return response()->json($request->all());
        $ajuste = Configuracion::firstOrFail();

        $rules = [
            'nombre_empresa' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'descripcion' => 'nullable|string|max:1000',
            'cuit' => 'nullable|string|max:20',
            'ciudad' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            'imagen_login' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
        ];

        $data = $request->validate($rules);

        // Datos simples
        $ajuste->nombre_empresa = $data['nombre_empresa'];
        $ajuste->direccion = $data['direccion'];
        $ajuste->telefono = $data['telefono'];
        $ajuste->email = $data['email'];
        $ajuste->descripcion = $data['descripcion'];
        $ajuste->cuit = $data['cuit'];
        $ajuste->ciudad = $data['ciudad'];

        // LOGO
        if ($request->hasFile('logo')) {
            if ($ajuste->logo) {
                Storage::disk('public')->delete($ajuste->logo);
            }
            $ajuste->logo = $request->file('logo')->store('logos', 'public');
        }

        // IMAGEN LOGIN
        if ($request->hasFile('imagen_login')) {
            if ($ajuste->imagen_login) {
                Storage::disk('public')->delete($ajuste->imagen_login);
            }
            $ajuste->imagen_login = $request->file('imagen_login')->store('imagenes_login', 'public');
        }

        $ajuste->save();

        return redirect()->route('admin.configuracion.index')->with('swal', [
            'icon' => 'success',
            'title' => 'Ajustes actualizados correctamente',
            'timer' => 2000
        ]);
    }
}
