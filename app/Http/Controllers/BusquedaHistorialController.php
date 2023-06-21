<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DatoPaciente;
class BusquedaHistorialController extends Controller
{
    public function showHistorial()
    {
        return view('one.historial');
    }
    public function searchHistorial(Request $request)
    {
        $patientId = $request->input('patientId');

        // Buscar al paciente en la base de datos por su ID
        $patient = DatoPaciente::where('n_h_clinico', $patientId)->first();

        if ($patient) {
            // El paciente fue encontrado, devolver los datos del paciente
            return response()->json([
                'found' => true,
                'patientData' => $patient
            ]);
        } else {
            // El paciente no fue encontrado
            return response()->json([
                'found' => false,
                'patientData' => null
            ]);
        }
    }
}
