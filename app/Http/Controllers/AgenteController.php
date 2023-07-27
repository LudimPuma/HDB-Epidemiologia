<?php

namespace App\Http\Controllers;

use App\Agente;
use Illuminate\Http\Request;

class AgenteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    $agentes = Agente::orderBy('cod_agente_causal')->get();
    return view('one.crudAgente', compact('agentes'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('one.agente.crear');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:100',
        ]);

        $agente = Agente::create($request->all());

        // Devolver una respuesta JSON con el nuevo registro creado
        return response()->json(['agente' => $agente], 201);
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Agente  $agente
     * @return \Illuminate\Http\Response
     */
    public function show(Agente $agente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Agente  $agente
     * @return \Illuminate\Http\Response
     */
    public function edit(Agente $agente)
    {
        //
        return view('one.agente.index', compact('agente'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Agente  $agente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Agente $agente)
    {
        //
        $request->validate([
            'nombre' => 'required|max:100',
        ]);

        $agente->update($request->all());

        return redirect()->route('agente.index')->with('success', 'Agente actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Agente  $agente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Agente $agente)
    {
        //
        $agente->delete();

        return redirect()->route('agente.index')->with('success', 'Agente eliminado exitosamente');
    }

}
