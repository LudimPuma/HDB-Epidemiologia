<?php

namespace App\Http\Controllers;

use App\Servicio;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
class ServicioController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:crud-index-servicio')->only('index');
        $this->middleware('can:crud-create-servicio')->only('store');
        $this->middleware('can:crud-edit-servicio')->only('update');
    }
    public function index()
    {
        $servicios = Servicio::orderBy('cod_servicio')->get();
        return view('one.crudServicio', compact('servicios'));
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
            Servicio::create($request->all());
            return redirect()->route('servicio.index')->with('success', 'Servicio creado exitosamente');
        }catch (QueryException $e) {
            return redirect()->back()->withErrors(['El nombre ya existe en la tabla servicios.']);
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
            $servicio = Servicio::findOrFail($id);
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
            $servicio->update($data);
            return redirect()->route('servicio.index')->with('success', 'Antibiotico actualizado exitosamente');
        } catch (QueryException $e) {
            return redirect()->back()->withErrors(['El nombre ya existe en la tabla Antibioticos.']);
        }

    }
}
