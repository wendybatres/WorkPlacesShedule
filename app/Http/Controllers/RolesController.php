<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    public function index()
    {
        $role = Roles::all();
        return view('roles.index', [
            'roles' => $role
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('roles.create',[
            'role' => new Roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Roles::create($this->getParams($request));
        return redirect()->route('roles.index')->with('success', 'Rol creado correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Roles $role)
    {
        return view('roles.edit',[
            'role' => $role
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Roles $role)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);
        $role->update($validatedData);
        return redirect()->route('roles.index')->with('success', 'Rol actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Roles $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Rol eliminado correctamente');
        
    }

    public function getParams($request)
    {
        $params = $request->all();
        return $params;
    }
}
