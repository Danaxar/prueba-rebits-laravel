<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehiculo;
use App\Models\Vehiculos;
use App\Models\Usuarios;
use Illuminate\Support\Facades\DB;
use App\Models\Historicos;

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

    public function update(Request $request, $id)
    {
        // Buscar el vehículo por ID
        $vehiculo = Vehiculos::find($id);

        if (!$vehiculo) {
            return response()->json(['message' => 'Vehículo no encontrado'], 404);
        }

        // Actualizar el vehículo
        $vehiculo->update($request->all());

        return response()->json($vehiculo);
    }

    /* Objecto de entrada:
    {
        usuario: {...}
        vehiculo: {...}
    }
    */
    public function nuevoDueno(Request $request)
    {
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        // Buscar objetos en la bd
        $vehiculo = Vehiculos::find($request->vehiculo["id"]);
        $usuarioEncontrado = Usuarios::where('correo', $request->usuario["correo"])->first();

        // Verificar existencia de vehículo
        if (!$vehiculo) {
            return response()->json(['message' => 'Vehículo o Usuario no encontrado'], 404);
        }

        DB::beginTransaction();
        try {
            if ($usuarioEncontrado == null) {  // Si no existe
                $out->writeln("Creando usuario...");
                // Crear el nuevo usuario
                $newUser = new Usuarios();
                $newUser->nombre = $request->usuario["nombre"];
                $newUser->apellidos = $request->usuario["apellidos"];
                $newUser->correo = $request->usuario["correo"];
                $newUser->save();
                dump($newUser);
                $vehiculo->id_usuario = $newUser->id;
            } else {
                $out->writeln("Usuario encontrado...");
                $vehiculo->id_usuario = $usuarioEncontrado->id;
                dump($usuarioEncontrado);
            }
            $vehiculo->save();

            // Agregar al histórico
            $historico = new Historicos();
            $historico->id_usuario = $vehiculo->id_usuario;
            $historico->id_vehiculo = $vehiculo->id;
            $historico->fecha_inicio = date('Y-m-d H:i:s');
            $historico->save();

            DB::commit();
            return response()->json(['message' => 'Vehículo actualizado correctamente'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al guardar el vehículo', 'error' => $e->getMessage()], 500);
        }
    }
}
