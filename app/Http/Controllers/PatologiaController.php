<?php

namespace App\Http\Controllers;

use App\Patologia;
use Illuminate\Http\Request;

class PatologiaController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:crud-index-patologia')->only('index');
        $this->middleware('can:crud-create-patologia')->only('store');
        $this->middleware('can:crud-edit-patologia')->only('update');
    }
    public function index()
    {
        $patologias = Patologia::orderBy('nombre')->get();
        return view('one.crudPatologia', compact('patologias'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:100',
        ]);
        Patologia::create($request->all());
        return redirect()->route('patologia.index')->with('success', 'Patologia creado exitosamente');
    }
    public function update(Request $request, Patologia $patologia)
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
        $patologia->update($data);
        return redirect()->route('patologia.index')->with('success', 'Patologia actualizado exitosamente');
    }
}
