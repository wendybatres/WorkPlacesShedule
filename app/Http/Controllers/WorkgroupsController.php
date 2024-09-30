<?php

namespace App\Http\Controllers;

use App\Models\Workgroups;
use Illuminate\Http\Request;

class WorkgroupsController extends Controller
{
    public function index()
    {
        $workgroup = Workgroups::all();
        return view('workgroups.index', [
            'workgroups' => $workgroup
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('workgroups.create',[
            'workgroup' => new Workgroups
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Workgroups::create($this->getParams($request));
        return redirect()->route('workgroups.index')->with('success', 'Grupo creado correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Workgroups $workgroup)
    {
        return view('workgroups.edit',[
            'workgroup' => $workgroup
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Workgroups $workgroup)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);
        $workgroup->update($validatedData);
        return redirect()->route('workgroups.index')->with('success', 'Grupo actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Workgroups $workgroup)
    {
        $workgroup->delete();
        return redirect()->route('workgroups.index')->with('success', 'Grupo eliminado correctamente');
    }

    public function getParams($request)
    {
        $params = $request->all();
        return $params;
    }
}
