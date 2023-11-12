<?php

namespace App\Http\Controllers;

use App\Bacteria;
use App\Medicamento;
use Illuminate\Http\Request;

class BacteriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:crud-index-bacteria')->only('index');
        $this->middleware('can:crud-create-bacteria')->only('store');
        $this->middleware('can:crud-edit-bacteria')->only('update');
    }
    public function index()
    {
        $bacterias = Bacteria::orderBy('nombre')->get();
        $medicamentos = Medicamento::orderBy('nombre')->where('estado',true)->get();
        return view('one.crudBacteria', compact('bacterias','medicamentos'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|letters_spaces',
        ]);
        $bacteria = Bacteria::create($request->except('medicamentos'));
        $bacteria->medicamentos()->sync($request->input('medicamentos'));

        return redirect()->route('bacteria.index')->with('success', 'Bacteria creada exitosamente');
    }
    public function update(Request $request, Bacteria $bacteria)
    {
        $request->validate([
            'nombre' => 'required|letters_spaces',
            'estado' => 'required|only_zero_one',
        ]);

        $data = [
            'nombre' => $request->nombre,
            'estado' => $request->estado,
        ];

        if (!$request->estado) {
            $request->validate([
                'motivos_baja' => 'required|letters_dash_spaces_dot',
            ],
            [
                'motivos_baja.required' => 'Debe proporcionar un motivo de baja',
            ]);
            $data['motivos_baja'] = $request->motivos_baja;
        } else {
            $data['motivos_baja'] = null;
        }

        // Actualiza la bacteria con los datos proporcionados
        $bacteria->update($data);

        // Sincroniza los medicamentos
        $bacteria->medicamentos()->sync($request->input('medicamentos'));

        return redirect()->route('bacteria.index')->with('success', 'Bacteria actualizada exitosamente');
    }



    // public function update(Request $request, Bacteria $bacteria)
    // {
    //     $request->validate([
    //         'nombre' => 'required|max:100',
    //     ]);

    //     $bacteria->update($request->except('medicamentos'));

    //     // Actualizar la relación de medicamentos de la bacteria
    //     $bacteria->medicamentos()->sync($request->input('medicamentos'));

    //     return redirect()->route('bacteria.index')->with('success', 'Bacteria actualizada exitosamente');
    // }

}
