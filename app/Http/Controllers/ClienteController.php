<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::withTrashed()->get();
        return view('admin.clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'numero_documento' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:clientes,email',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string' => 'El nombre debe ser una cadena de caracteres.',
            'nombre.max' => 'El nombre no puede tener más de 255 caracteres.',
            'numero_documento.required' => 'El valor es obligatorio.',
            'numero_documento.string' => 'El valor debe ser una cadena de caracteres.',
            'numero_documento.max' => 'El valor no puede tener más de 255 caracteres.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.string' => 'El teléfono debe ser una cadena de caracteres.',
            'telefono.max' => 'El teléfono no puede tener más de 255 caracteres.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email debe ser una dirección de correo válida.',
            'email.max' => 'El email no puede tener más de 255 caracteres.',
            'email.unique' => 'Ya existe un cliente con ese email.',
        ]);

        Cliente::create([
            'nombre' => $request->nombre,
            'numero_documento' => $request->numero_documento,
            'telefono' => $request->telefono,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.clientes.index')->with('swal', [
            'icon' => 'success',
            'title' => 'Cliente creado exitosamente',
            'timer' => 2000
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //$cliente = Cliente::with('ventas')->findOrFail($id);
        $cliente = Cliente::findOrFail($id);
        return view('admin.clientes.show', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('admin.clientes.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'numero_documento' => 'required|string|max:255',
            'telefono' => 'required|string|max:25',
            'email' => 'required|email|max:255|unique:clientes,email,' . $cliente->id,
        ]);

        $cliente->update([
            'nombre' => $request->nombre,
            'numero_documento' => $request->numero_documento,
            'telefono' => $request->telefono,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.clientes.index')->with('swal', [
            'icon' => 'success',
            'title' => 'Cliente actualizado exitosamente',
            'timer' => 2000
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);

        $cliente->delete();

        return redirect()->route('admin.clientes.index')->with('swal', [
            'icon' => 'success',
            'title' => 'Cliente eliminado correctamente',
            'timer' => 2000
        ]);
    }

    public function restaurar($id)
    {
        $producto = Cliente::withTrashed()->findOrFail($id);

        $producto->restore();

        return redirect()->route('admin.clientes.index')->with('swal', [
            'icon' => 'success',
            'title' => 'Cliente restaurado correctamente',
            'timer' => 2000
        ]);
    }
}
