<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ExcelImport;
use Maatwebsite\Excel\Facades\Excel;
// use Excel; // Otra forma de importar la clase
use Symfony\Component\Console\Output\ConsoleOutput;
use App\Mail\ExcelImportNotification;
use Illuminate\Support\Facades\Mail;

class ExcelController extends Controller
{
    // API
    public function upload(Request $request)
    {

        $output = new ConsoleOutput();
        $output->writeln('Leyendo archivo...');
        // Lee el archivo excel que viene en la $request
        // y lo importa con la clase ExcelImport
        // Esta clase para funcionar necesita los métodos
        // collection y model
        $import = new ExcelImport();
        Excel::import($import, $request->file('file'));

        $output->writeln('Enviando correo de notificación...');
        $mensajeCorreo = '';
        if (count($import->getMessages()) == 0) {
            $mensajeCorreo = '¡El archivo excel se ha procesado exitosamente!';
        } else {
            $mensajeCorreo = 'El archivo excel se ha procesado con alertas.';
        }
        try {
            // Mail::to('daniel.catalan@usach.cl')->send(new ExcelImportNotification($mensajeCorreo));
            Mail::to(env('EMAIL_TO'))->send(new ExcelImportNotification($mensajeCorreo));
        } catch (\Exception $e) {
            $output->writeln('Error al enviar el correo: ' . $e->getMessage());
        }
        // Obtener los mensajes post importación
        return response()->json([
            'messages' => $import->getMessages(),
            'status' => 'success',
            'rows' => $import->getLines()
        ], 200);
    }
}
