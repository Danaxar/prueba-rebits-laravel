<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehiculo;
use App\Models\Vehiculos;
use App\Models\Usuarios;

class VehiculoController extends Controller
{
    // API
    // Obtiene todos los vehiculos
    public function getAll()
    {
        try {
            $vehiculos = Vehiculos::all();
            return response()->json($vehiculos, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al obtener los vehiculos', 'error' => $e->getMessage()], 500);
        }
    }

    // Obtiene un vehiculo por id
    public function getById($id)
    {
        // Buscar el vehículo por ID
        $vehiculo = Vehiculos::find($id);

        if (!$vehiculo) {
            return response()->json(['message' => 'Vehículo no encontrado'], 404);
        }

        return response()->json($vehiculo);
    }

    // Obtiene el dueño de un vehiculo según el id del vehiculo
    public function getDueno($id)
    {
        $vehiculo = Vehiculos::find($id);  // Obtener el vehiculo desde la bd
        $idDueno = $vehiculo->id_usuario;  // Obtener el id del dueño

        // Traer el objeto usuario desde la bd
        try {
            $dueno = Usuarios::find($idDueno);
            return response()->json($dueno, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al obtener el dueño', 'error' => $e->getMessage()], 500);
        }
    }
}
