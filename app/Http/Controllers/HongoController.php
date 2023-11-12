<?php

namespace App\Http\Controllers;

use App\Hongo;
use Illuminate\Http\Request;

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
        $request->validate([
            'nombre' => 'required|letters_spaces',
        ]);
        Hongo::create($request->all());
        return redirect()->route('hongo.index')->with('success', 'Hongo creado exitosamente');
    }
    public function update(Request $request, Hongo $hongo)
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
        $hongo->update($data);
        return redirect()->route('hongo.index')->with('success', 'Hongo actualizado exitosamente');
    }
}
