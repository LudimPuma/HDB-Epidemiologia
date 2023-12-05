<?php

namespace App\Http\Controllers;

use App\Hongo;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
class HongoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:crud-index-hongo')->only('index');
        $this->middleware('can:crud-create-hongo')->only('store');
        $this->middleware('can:crud-edit-hongo')->only('update');
    }
    public function index()
    {
        $hongos = Hongo::orderBy('id')->get();
        return view('one.crudHongo', compact('hongos'));
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
            Hongo::create($request->all());
            return redirect()->route('hongo.index')->with('success', 'Hongo creado exitosamente');
        } catch (QueryException $e) {
            return redirect()->back()->withErrors(['El nombre ya existe en la tabla Hongo.']);
        }

    }
    // public function update(Request $request, Hongo $hongo)
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
            $hongo = Hongo::findOrFail($id);
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
            $hongo->update($data);
            return redirect()->route('hongo.index')->with('success', 'Hongo actualizado exitosamente');

        } catch (QueryException $e) {
            return redirect()->back()->withErrors(['El nombre ya existe en la tabla Hongo.']);
        }
    }
}
