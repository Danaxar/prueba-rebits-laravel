<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuarios;
use Illuminate\Support\Facades\Log;

class UsuariosController extends Controller
{
    public function getAll()
    {
        try {
            $usuarios = Usuarios::all();
            return response()->json($usuarios, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al obtener los usuarios', 'error' => $e->getMessage()], 500);
        }
    }
}
