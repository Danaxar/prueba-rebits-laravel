<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ExcelImport;
use Maatwebsite\Excel\Facades\Excel;
// use Excel; // Otra forma de importar la clase

class ExcelController extends Controller
{
    // API
    public function upload(Request $request)
    {
        // Lee el archivo excel que viene en la $request
        // y lo importa con la clase ExcelImport
        // Esta clase para funcionar necesita los métodos
        // collection y model
        $import = new ExcelImport();
        Excel::import($import, $request->file('file'));

        // Obtener los mensajes post importación
        return response()->json([
            'messages' => $import->getMessages()
        ]);
    }
}
