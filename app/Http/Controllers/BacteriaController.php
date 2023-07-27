<?php

namespace App\Http\Controllers;

use App\Bacteria;
use Illuminate\Http\Request;

class BacteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $bacterias = Bacteria::orderBy('cod_bacterias')->get();
        return view('one.crudBacteria', compact('bacterias'));
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

        Bacteria::create($request->all());

        return redirect()->route('bacteria.index')->with('success', 'Medicamento creado exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bacteria  $bacteria
     * @return \Illuminate\Http\Response
     */
    public function show(Bacteria $bacteria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bacteria  $bacteria
     * @return \Illuminate\Http\Response
     */
    public function edit(Bacteria $bacteria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bacteria  $bacteria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bacteria $bacteria)
    {
        //
        $request->validate([
            'nombre' => 'required|max:100',
        ]);

        $bacteria->update($request->all());

        return redirect()->route('bacteria.index')->with('success', 'bacteria actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bacteria  $bacteria
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bacteria $bacteria)
    {
        //
        $bacteria->delete();
        return redirect()->route('bacteria.index')->with('success', 'Medicamento eliminado exitosamente');
    }

    public function search(Request $request)
    {
      $query = $request->input('query');

      $bacterias = Bacteria::where('nombre', 'like', '%'.$query.'%')->get();

      return response()->json($bacterias);
    }

}
