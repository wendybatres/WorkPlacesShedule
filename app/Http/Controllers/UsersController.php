<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\Roles;
use App\Models\Workgroups;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        $user = auth()->user()->get();
        return view('users.index', [
            'users' => $user
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create',[
            'user' => new Users,
            'roles' => Roles::all(),
            'workgroups' => Workgroups::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Users::create($this->getParams($request));
        return redirect()->route('users.index')->with('success', 'Usuario creado correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Users $user)
    {
        return view('users.edit',[
            'user' => $user,
            'roles' => Roles::all(),
            'workgroups' => Workgroups::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Users $user)
    {
        $user->update($this->getParams($request));
        return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Users $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuario eliminado correctamente');
    }

    public function getParams($request)
    {
        $params = $request->all();
        return $params;
    }
}
