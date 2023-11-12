<?php

namespace App\Http\Controllers;

use App\Medicamento;
use Illuminate\Http\Request;

class MedicamentoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:crud-index-medicamento')->only('index');
        $this->middleware('can:crud-create-medicamento')->only('store');
        $this->middleware('can:crud-edit-medicamento')->only('update');
    }
    public function index()
    {
        $medicamentos = Medicamento::orderBy('cod_medicamento')->get();
        return view('one.crudMedicamento', compact('medicamentos'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|letters_spaces',
        ]);
        Medicamento::create($request->all());
        return redirect()->route('medicamento.index')->with('success', 'Medicamento creado exitosamente');
    }
    public function update(Request $request, Medicamento $medicamento)
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
        $medicamento->update($data);
        return redirect()->route('medicamento.index')->with('success', 'Medicamento actualizado exitosamente');
    }

}
