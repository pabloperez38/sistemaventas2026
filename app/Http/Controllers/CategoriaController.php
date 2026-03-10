<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Categoria::all();
        return view('admin.categorias.index', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //return response()->json($request->all());

        $request->validate([
            'nombre' => 'required|string|max:255'
        ]);

        Categoria::create([
            'nombre' => $request->nombre
        ]);

        return redirect()->route('admin.categorias.index')->with('swal', [
            'icon' => 'success',
            'title' => 'Categoría creada exitosamente',
            'timer' => 2000
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('admin.categorias.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255'
        ]);

        $categoria = Categoria::findOrFail($id);

        $categoria->update([
            'nombre' => $request->nombre
        ]);

        return redirect()->route('admin.categorias.index')->with('swal', [
            'icon' => 'success',
            'title' => 'Categoría actualizada exitosamente',
            'timer' => 2000
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categoria)
    {
        //
    }
}
