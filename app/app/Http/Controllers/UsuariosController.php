<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;

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
