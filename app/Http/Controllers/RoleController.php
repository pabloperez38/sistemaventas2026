<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|unique:roles,name',
            ],
            [
                'name.required' => 'El nombre del rol es obligatorio.',
                'name.unique' => 'Ya existe un rol con ese nombre.',
            ]
        );

        Role::create(['name' => $request->name]);

        return redirect()->route('admin.roles.index')->with('swal', [
            'icon' => 'success',
            'title' => 'Rol creado exitosamente',
            'timer' => 2000
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::findOrFail($id);
        return view('admin.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = Role::findOrFail($id);

        $request->validate(
            [
                'name' => 'required|unique:roles,name,' . $role->id,
            ],
            [
                'name.required' => 'El nombre del rol es obligatorio.',
                'name.unique' => 'Ya existe un rol con ese nombre.',
            ]
        );

        $role->update(['name' => $request->name]);

        return redirect()->route('admin.roles.index')->with('swal', [
            'icon' => 'success',
            'title' => 'Rol actualizado exitosamente',
            'timer' => 2000
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('admin.roles.index')->with('swal', [
            'icon' => 'success',
            'title' => 'Rol eliminado exitosamente',
            'timer' => 2000
        ]);
    }
}
