<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proveedores = Proveedor::withTrashed()->get();
        return view('admin.proveedores.index', compact('proveedores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.proveedores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'empresa' => 'required|string|max:255',
            'cuit' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'direccion' => 'required|string|max:255',

        ], [
            'empresa.required' => 'El nombre de la empresa es obligatorio.',
            'empresa.string' => 'El nombre de la empresa debe ser una cadena de caracteres.',
            'empresa.max' => 'El nombre de la empresa no puede tener más de 255 caracteres.',
            'cuit.required' => 'El CUIT es obligatorio.',
            'cuit.string' => 'El cuit debe ser una cadena de caracteres.',
            'cuit.max' => 'El cuit no puede tener más de 255 caracteres.',
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string' => 'El nombre debe ser una cadena de caracteres.',
            'nombre.max' => 'El nombre no puede tener más de 255 caracteres.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.string' => 'El teléfono debe ser una cadena de caracteres.',
            'telefono.max' => 'El teléfono no puede tener más de 255 caracteres.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email debe ser una dirección de correo válida.',
            'email.max' => 'El email no puede tener más de 255 caracteres.',
            'direccion.required' => 'La dirección es obligatoria.',
            'direccion.string' => 'La dirección debe ser una cadena de caracteres.',
            'direccion.max' => 'La dirección no puede tener más de 255 caracteres.',

        ]);

        Proveedor::create([
            'empresa' => $request->empresa,
            'cuit' => $request->cuit,
            'nombre' => $request->nombre,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'direccion' => $request->direccion,
        ]);

        return redirect()->route('admin.proveedores.index')->with('swal', [
            'icon' => 'success',
            'title' => 'Proveedor creado exitosamente',
            'timer' => 2000
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        return view('admin.proveedores.edit', compact('proveedor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $proveedor = Proveedor::findOrFail($id);

        $request->validate([
            'empresa' => 'required|string|max:255',
            'cuit' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'direccion' => 'required|string|max:255',

        ], [
            'empresa.required' => 'El nombre de la empresa es obligatorio.',
            'empresa.string' => 'El nombre de la empresa debe ser una cadena de caracteres.',
            'empresa.max' => 'El nombre de la empresa no puede tener más de 255 caracteres.',
            'cuit.required' => 'El CUIT es obligatorio.',
            'cuit.string' => 'El cuit debe ser una cadena de caracteres.',
            'cuit.max' => 'El cuit no puede tener más de 255 caracteres.',
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string' => 'El nombre debe ser una cadena de caracteres.',
            'nombre.max' => 'El nombre no puede tener más de 255 caracteres.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.string' => 'El teléfono debe ser una cadena de caracteres.',
            'telefono.max' => 'El teléfono no puede tener más de 255 caracteres.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email debe ser una dirección de correo válida.',
            'email.max' => 'El email no puede tener más de 255 caracteres.',
            'direccion.required' => 'La dirección es obligatoria.',
            'direccion.string' => 'La dirección debe ser una cadena de caracteres.',
            'direccion.max' => 'La dirección no puede tener más de 255 caracteres.',
        ]);
        $proveedor->update([
            'empresa' => $request->empresa,
            'cuit' => $request->cuit,
            'nombre' => $request->nombre,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'direccion' => $request->direccion,
        ]);

        return redirect()->route('admin.proveedores.index')->with('swal', [
            'icon' => 'success',
            'title' => 'Proveedor actualizado exitosamente',
            'timer' => 2000
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $proveedor = Proveedor::findOrFail($id);

        $proveedor->activo = 0;
        $proveedor->save();

        $proveedor->delete();

        return redirect()->route('admin.proveedores.index')->with('swal', [
            'icon' => 'success',
            'title' => 'Proveedor eliminado correctamente',
            'timer' => 2000
        ]);
    }

    public function restaurar($id)
    {
        $proveedor = Proveedor::withTrashed()->findOrFail($id);

        $proveedor->restore();
        $proveedor->activo = 1;
        $proveedor->save();

        return redirect()->route('admin.proveedores.index')->with('swal', [
            'icon' => 'success',
            'title' => 'Proveedor restaurado correctamente',
            'timer' => 2000
        ]);
    }
}
