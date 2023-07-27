<?php

namespace App\Http\Controllers;

use App\TipoInfeccion;
use Illuminate\Http\Request;

class TipoInfeccionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tInfecciones = TipoInfeccion::orderBy('cod_tipo_infeccion')->get();
        return view('one.crudTipoInfeccion', compact('tInfecciones'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

        TipoInfeccion::create($request->all());

        return redirect()->route('tipoInfeccion.index')->with('success', 'Tipo Infeccion creado exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TipoInfeccion  $tipoInfeccion
     * @return \Illuminate\Http\Response
     */
    public function show(TipoInfeccion $tipoInfeccion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TipoInfeccion  $tipoInfeccion
     * @return \Illuminate\Http\Response
     */
    public function edit(TipoInfeccion $tipoInfeccion)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TipoInfeccion  $tipoInfeccion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TipoInfeccion $tipoInfeccion)
    {
        //
        $request->validate([
            'nombre' => 'required|max:100',
        ]);

        $tipoInfeccion->update($request->all());

        return redirect()->route('tipoInfeccion.index')->with('success', 'Tipo Infeccion actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TipoInfeccion  $tipoInfeccion
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoInfeccion $tipoInfeccion)
    {
        //
        $tipoInfeccion->delete();

        return redirect()->route('tipoInfeccion.index')->with('success', 'Tipo Infeccion eliminado exitosamente');
    }
    public function search(Request $request)
    {
      $query = $request->input('query');

      $bacterias = TipoInfeccion::where('nombre', 'like', '%'.$query.'%')->get();

      return response()->json($bacterias);
    }
}
