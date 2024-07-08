<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Historicos;
use Illuminate\Support\Facades\DB;

class HistoricoController extends Controller
{
    public function getAll()
    {
        try {
            $historicos = DB::table('historicos')
                ->join('usuarios', 'historicos.id_usuario', '=', 'usuarios.id')
                ->join('vehiculos', 'historicos.id_vehiculo', '=', 'vehiculos.id')
                ->select('historicos.*', 'usuarios.nombre as nombre_usuario', 'usuarios.apellidos as apellidos_usuario', 'usuarios.correo as correo_usuario', 'vehiculos.marca as marca_vehiculo', 'vehiculos.modelo as modelo_vehiculo', 'vehiculos.anio as anio_vehiculo', 'vehiculos.precio as precio_vehiculo', 'vehiculos.patente as patente_vehiculo')
                ->get();
            return response()->json($historicos, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al obtener el historico', 'error' => $e->getMessage()], 500);
        }
    }
}
