<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\workplacesshedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class WorkplacessheduleController extends Controller
{
     /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'userid' => 'required|integer',
            'shedule' => 'required|date',
        ]);

        try {
            // Intenta insertar el nuevo registro
            DB::table('workplacesshedule')->insert([
                'userid' => $request->userid,
                'shedule' => $request->shedule,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect('/home')->with('success', 'Registro creado exitosamente');
        } catch (QueryException $e) {
            // Manejar el error de duplicación
            if ($e->getCode() == 23000) { // Código de error para duplicados
                return redirect('/home')->with('error', 'Ya existe un registro para este usuario y horario');
            }

            // Manejar otros errores de la base de datos
            return redirect('/home')->with('error', 'Error al guardar el registro');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function getParams($request)
    {
        $params = $request->all();

        return $params;
    }
}
