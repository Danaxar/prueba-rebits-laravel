<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Illuminate\Http\Request;

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

    public function register(Request $request)
    {
        try {
            $usuario = new Usuarios();
            $usuario->nombre = $request->nombre;
            $usuario->apellido = $request->apellido;
            $usuario->correo = $request->correo;
            $usuario->save();
            return response()->json(['message' => 'Usuario registrado correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al registrar el usuario', 'error' => $e->getMessage()], 500);
        }
    }
}
