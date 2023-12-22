<?php

namespace App\Http\Controllers;

use App\TipoMuestra;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
class TipoMuestraController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:crud-index-tipoMuestra')->only('index');
        $this->middleware('can:crud-create-tipoMuestra')->only('store');
        $this->middleware('can:crud-edit-tipoMuestra')->only('update');
    }
    public function index()
    {
        $tipoMuestras = TipoMuestra::orderBy('cod_tipo_muestra')->get();
        return view('one.crudTipoMuestra', compact('tipoMuestras'));
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
            TipoMuestra::create($request->all());
            return redirect()->route('tipoMuestra.index')->with('success', 'Tipo de Muestra creado exitosamente');
        }catch (QueryException $e) {
            return redirect()->back()->withErrors(['El nombre ya existe en la tabla tipo de muestras invasivos.']);
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
            $tipoMuestra = TipoMuestra::findOrFail($id);
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
            $tipoMuestra->update($data);
            return redirect()->route('tipoMuestra.index')->with('success', 'Tipo de Muestra actualizado exitosamente');
        } catch (QueryException $e) {
            return redirect()->back()->withErrors(['El nombre ya existe en la tabla Tipo Muestra.']);
        }

    }
}
