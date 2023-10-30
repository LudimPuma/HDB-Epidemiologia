<?php

namespace App\Http\Controllers;

use App\TipoInfeccion;
use Illuminate\Http\Request;

class TipoInfeccionController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:crud-index-tipoInfeccion')->only('index');
        $this->middleware('can:crud-create-tipoInfeccion')->only('store');
        $this->middleware('can:crud-edit-tipoInfeccion')->only('update');
    }
    public function index()
    {
        $tInfecciones = TipoInfeccion::orderBy('nombre')->get();
        return view('one.crudTipoInfeccion', compact('tInfecciones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:100',
        ]);

        TipoInfeccion::create($request->all());
        $request->session()->flash('success', 'Tipo de Infección agregado exitosamente');
        return redirect()->route('tipoInfeccion.index')->with('success', 'Tipo Infeccion creado exitosamente');
    }

    public function update(Request $request, TipoInfeccion $tipoInfeccion)
    {
        $request->validate([
            'nombre' => 'required|max:100',
            'estado' => 'required|boolean',
        ]);

        $data = [
            'nombre' => $request->nombre,
            'estado' => $request->estado,
        ];

        if (!$request->estado) {
            $request->validate([
                'motivos_baja' => 'required',
            ],
            [
                'motivos_baja.required' => 'Debe proporcionar un motivo de baja',
            ]);
            $data['motivos_baja'] = $request->motivos_baja;
        } else {
            $data['motivos_baja'] = null;
        }

        $tipoInfeccion->update($data);

        $request->session()->flash('success', 'Estado actualizado exitosamente');

        return redirect()->route('tipoInfeccion.index');
    }
}
