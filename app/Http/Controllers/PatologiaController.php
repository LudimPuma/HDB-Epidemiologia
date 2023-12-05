<?php

namespace App\Http\Controllers;

use App\Patologia;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
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
        try {
            $request->validate([
                'nombre' => 'required|letters_dash_spaces_dot',
            ],
            [
                'nombre.required' => 'El nombre obigatorio',
                'nombre.letters_dash_spaces_dot' => 'Caracteres incorrectos',
            ]
            );
            Patologia::create($request->all());
            return redirect()->route('patologia.index')->with('success', 'Patologia creado exitosamente');
        } catch (QueryException $e) {
            return redirect()->back()->withErrors(['El nombre ya existe en la tabla patologia.']);
        }
    }
    // public function update(Request $request, Patologia $patologia)
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nombre' => ['required', 'letters_dash_spaces_dot'],
                'estado' => 'required|only_zero_one',
                'motivos_baja' =>'letters_dash_spaces_dot'
            ],
            [
                'nombre.required' => 'El nombre obigatorio',
                'nombre.letters_dash_spaces_dot' => 'Caracteres incorrectos',
                'estado.required' => 'El estado es obligatorio',
                'estado.only_zero_one' => 'El estado debe ser 0 o 1',
                'motivos_baja.letters_dash_spaces_dot' =>'Problemas en la validación, solo se permite letras, digitos y -/./()'
            ]
            );
            $patologia = Patologia::findOrFail($id);
            $data = [
                'nombre' => $request->nombre,
                'estado' => $request->estado,
            ];
            if (!$request->estado) {
                $request->validate([
                    'motivos_baja' => 'required|letters_dash_spaces_dot',
                ],
                [
                    'motivos_baja.required' => 'El motivo de baja es obligatorio si se deshabilita',
                    'motivos_baja.letters_dash_spaces_dot' =>'Problemas en la validación, solo se permite letras, digitos y -/./()'
                ]);
                $data['motivos_baja'] = $request->motivos_baja;
            } else {
                $data['motivos_baja'] = null;
            }
            $patologia->update($data);
            return redirect()->route('patologia.index')->with('success', 'Patologia actualizado exitosamente');
        } catch (QueryException $e) {
            return redirect()->back()->withErrors(['El nombre ya existe en la tabla patologia.']);
        }
    }
}
