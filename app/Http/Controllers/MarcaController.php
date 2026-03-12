<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $marcas = Marca::withTrashed()->get();
        return view('admin.marcas.index', compact('marcas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.marcas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|unique:marcas,nombre|max:255'
        ]);

        Marca::create([
            'nombre' => $request->nombre
        ]);

        return redirect()->route('admin.marcas.index')->with('swal', [
            'icon' => 'success',
            'title' => 'Marca creada exitosamente',
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
        $marca = Marca::findOrFail($id);
        return view('admin.marcas.edit', compact('marca'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $marca = Marca::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255|unique:marcas,nombre,' . $marca->id
        ]);

        $marca->update([
            'nombre' => $request->nombre
        ]);

        return redirect()->route('admin.marcas.index')->with('swal', [
            'icon' => 'success',
            'title' => 'Marca editada exitosamente',
            'timer' => 2000
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $marca = Marca::findOrFail($id);

        $marca->delete();

        return redirect()->route('admin.marcas.index')->with('swal', [
            'icon' => 'success',
            'title' => 'Marca eliminada correctamente',
            'timer' => 2000
        ]);
    }

    public function restore($id)
    {
        $marca = Marca::withTrashed()->findOrFail($id);

        $marca->restore();

        return redirect()->route('admin.marcas.index')->with('swal', [
            'icon' => 'success',
            'title' => 'Marca restaurada correctamente',
            'timer' => 2000
        ]);
    }
}
