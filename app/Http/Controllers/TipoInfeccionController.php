<?php

namespace App\Http\Controllers;

use App\TipoInfeccion;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
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
        try{
            $request->validate([
                'nombre' => 'required|letters_dash_spaces_dot',
            ],
            [
                'nombre.required' => 'El nombre no puede estar vacio',
                'nombre.letters_dash_spaces_dot' => 'El nombre no admite esos caracteres'
            ]
            );
            TipoInfeccion::create($request->all());
            return redirect()->route('tipoInfeccion.index')->with('success', 'Tipo Infeccion creado exitosamente');
        } catch (QueryException $e) {
            return redirect()->back()->withErrors(['El nombre ya existe en la tabla Tipo de Infeccion.']);
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
            $tipoInfeccion = TipoInfeccion::findOrFail($id);

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
                    'motivos_baja.letters_dash_spaces_dot' => 'No se aceptan esos caracteres en los motivos de baja',
                ]);
                $data['motivos_baja'] = $request->motivos_baja;
            } else {
                $data['motivos_baja'] = null;
            }

            $tipoInfeccion->update($data);

            $request->session()->flash('success', 'Estado actualizado exitosamente');

            return redirect()->route('tipoInfeccion.index');
        } catch (QueryException $e) {
            // return redirect()->back()->withErrors(['Error. Detalles: ' . $e->getMessage()]);
            return redirect()->back()->withErrors(['El nombre ya existe en la tabla Tipo Infección.']);
        }
    }

    // public function update(Request $request, TipoInfeccion $tipoInfeccion)
    // {
    //     $request->validate([
    //         'nombre' => 'required|numbers_dash_letters',
    //         'estado' => 'required|only_zero_one',
    //     ],
    //     [
    //         'nombre.required' => 'El nombre no puede estar vacio',
    //         'nombre.numbers_dash_letters' => 'No se aceptan ese tipo de caracteres',
    //         'estado.required' => 'El estado no puede estar vacio',
    //         'estado.only_zero_one' => 'El estado solo puede ser habilitado o deshabilitado',
    //     ]
    //     );

    //     $data = [
    //         'nombre' => $request->nombre,
    //         'estado' => $request->estado,
    //     ];

    //     if (!$request->estado) {
    //         $request->validate([
    //             'motivos_baja' => 'required|letters_dash_spaces_dot',
    //         ],
    //         [
    //             'motivos_baja.required' => 'Debe proporcionar un motivo de baja',
    //             'motivos_baja.required' => 'No se aceptan esos caracteres',
    //         ]);
    //         $data['motivos_baja'] = $request->motivos_baja;
    //     } else {
    //         $data['motivos_baja'] = null;
    //     }

    //     $tipoInfeccion->update($data);

    //     $request->session()->flash('success', 'Estado actualizado exitosamente');

    //     return redirect()->route('tipoInfeccion.index');
    // }
}
