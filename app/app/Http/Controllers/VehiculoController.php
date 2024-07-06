<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehiculo;
use App\Models\Vehiculos;

class VehiculoController extends Controller
{
    // API
    public function getAll()
    {
        try {
            $vehiculos = Vehiculos::all();
            return response()->json($vehiculos, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al obtener los vehiculos', 'error' => $e->getMessage()], 500);
        }
    }

    // Inertia

}
