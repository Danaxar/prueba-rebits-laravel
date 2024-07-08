<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Historicos;

class HistoricoController extends Controller
{
    public function getAll()
    {
        try {
            $historico = Historicos::all();
            return response()->json($historico, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al obtener el historico', 'error' => $e->getMessage()], 500);
        }
    }
}
