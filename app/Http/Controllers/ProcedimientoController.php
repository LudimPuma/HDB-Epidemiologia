<?php

namespace App\Http\Controllers;

use App\ProcedimientoInmasivo;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
class ProcedimientoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:crud-index-procedimiento')->only('index');
        $this->middleware('can:crud-create-procedimiento')->only('store');
        $this->middleware('can:crud-edit-procedimiento')->only('update');
    }
    public function index()
    {
        $procedimientos = ProcedimientoInmasivo::orderBy('cod_procedimiento_invasivo')->get();
        return view('one.crudProcedimiento', compact('procedimientos'));
    }
    public function store(Request $request)
    {
        try{
            $request->validate([
                'nombre' => 'required|letters_dash_spaces_dot',
            ],
            [
                'nombre.required' => 'El nombre obigatorio',
                'nombre.letters_dash_spaces_dot' => 'Caracteres incorrectos',
            ]
            );
            ProcedimientoInmasivo::create($request->all());
            return redirect()->route('procedimiento.index')->with('success', 'Procedimiento invasivo creado exitosamente');
        }catch (QueryException $e) {
            return redirect()->back()->withErrors(['El nombre ya existe en la tabla procedimientos invasivos.']);
        }
    }
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
            $procedimiento = ProcedimientoInmasivo::findOrFail($id);
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
            $procedimiento->update($data);
            return redirect()->route('procedimiento.index')->with('success', 'Procedimiento invasivo actualizado exitosamente');
        } catch (QueryException $e) {
            return redirect()->back()->withErrors(['El nombre ya existe en la tabla Procedimientos invasivos.']);
        }

    }
}
