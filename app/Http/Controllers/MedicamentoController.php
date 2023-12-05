<?php

namespace App\Http\Controllers;

use App\Medicamento;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
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
        try{
            $request->validate([
                'nombre' => 'required|numbers_dash_letters',
            ],
            [
                'nombre.required' => 'El nombre obigatorio',
                'nombre.numbers_dash_letters' => 'Caracteres incorrectos',
            ]
            );
            Medicamento::create($request->all());
            return redirect()->route('medicamento.index')->with('success', 'Medicamento creado exitosamente');
        }catch (QueryException $e) {
            return redirect()->back()->withErrors(['El nombre ya existe en la tabla Antibioticos.']);
        }

    }
    // public function update(Request $request, Medicamento $medicamento)
    public function update(Request $request, $id)
    {
        try{
            $request->validate([
                'nombre' => 'required|letters_dash_spaces_dot',
                'estado' => 'required|only_zero_one',
            ],
            [
                'nombre.required' => 'El nombre no puede estar vacio',
                'nombre.letters_dash_spaces_dot' => 'El nombre no admite esos caracteres',
                'estado.required' => 'El estado no puede estar vacio',
                'estado.only_zero_one' => 'El estado debe ser habilitado o deshabilitado',
            ]
            );
            $medicamento = Medicamento::findOrFail($id);
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
            return redirect()->route('medicamento.index')->with('success', 'Antibiotico actualizado exitosamente');
        } catch (QueryException $e) {
            return redirect()->back()->withErrors(['El nombre ya existe en la tabla Antibioticos.']);
        }

    }

}
