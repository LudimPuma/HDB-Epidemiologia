<?php

namespace App\Http\Controllers;

use App\Bacteria;
use App\Medicamento;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
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
        try{
            $request->validate([
                'nombre' => 'required|letters_dash_spaces_dot',
            ],
            [
                'nombre.required' => 'El nombre no puede estar vacio',
                'nombre.letters_dash_spaces_dot' => 'El nombre no admite esos caracteres'
            ]
            );
            $bacteria = Bacteria::create($request->except('medicamentos'));
            $bacteria->medicamentos()->sync($request->input('medicamentos'));

            return redirect()->route('bacteria.index')->with('success', 'Bacteria creada exitosamente');
        } catch (QueryException $e) {
            // return redirect()->back()->withErrors(['Error. Detalles: ' . $e->getMessage()]);
            return redirect()->back()->withErrors(['El nombre ya existe en la tabla Bacterias.']);
        }

    }
    public function update(Request $request, Bacteria $bacteria)
    {
        try {
            if ($bacteria->id != $request->id) {
                return redirect()->route('bacteria.index')->withErrors(['Error: ID de bacteria no válido.']);
            }

            $request->validate([
                'nombre' => 'required|letters_dash_spaces_dot',
                'estado' => 'required|only_zero_one',
            ],
            [
                'nombre.required' => 'El nombre no puede guardarse vacio',
                'nombre.letters_dash_spaces_dot' => 'No se permiten esos caracteres',
                'estado.required' => 'El estado no puede guardarse vacio',
                'estado.only_zero_one' => 'El estado solo puede ser habilitado o deshabilitado',
            ]
            );
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

            $bacteria->update($data);

            $bacteria->medicamentos()->sync($request->input('medicamentos'));

            return redirect()->route('bacteria.index')->with('success', 'Bacteria actualizada exitosamente');
        } catch (QueryException $e) {
            return redirect()->back()->withErrors(['El nombre ya existe en la tabla Bacterias.']);
        }
    }

    // public function update(Request $request, Bacteria $bacteria)
    // {
    //     try{
    //         $request->validate([
    //             'nombre' => 'required|letters_spaces',
    //             'estado' => 'required|only_zero_one',
    //         ]);

    //         $data = [
    //             'nombre' => $request->nombre,
    //             'estado' => $request->estado,
    //         ];

    //         if (!$request->estado) {
    //             $request->validate([
    //                 'motivos_baja' => 'required|letters_dash_spaces_dot',
    //             ],
    //             [
    //                 'motivos_baja.required' => 'Debe proporcionar un motivo de baja',
    //             ]);
    //             $data['motivos_baja'] = $request->motivos_baja;
    //         } else {
    //             $data['motivos_baja'] = null;
    //         }

    //         $bacteria->update($data);

    //         $bacteria->medicamentos()->sync($request->input('medicamentos'));

    //         return redirect()->route('bacteria.index')->with('success', 'Bacteria actualizada exitosamente');
    //     } catch (QueryException $e) {
    //         return redirect()->back()->withErrors(['Error. Detalles: ' . $e->getMessage()]);
    //     }
    // }

}
