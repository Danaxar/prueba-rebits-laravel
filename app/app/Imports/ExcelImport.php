<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Usuarios;
use App\Models\Vehiculos;
use Illuminate\Support\Facades\DB;

class ExcelImport implements ToModel
{
    private $current = 0;
    private $messages = [];


    // Manda un mensaje a la lista
    public function newMessage($m)
    {
        array_push($this->messages, "Error en la fila " . $this->current . ": " . $m);
    }

    // Obtiene todos los mensajes de la lista
    public function getMessages()
    {
        return $this->messages;
    }

    public function getLines()
    {
        return $this->current;
    }

    // Debe llamarse model para que funcione (Viene de ToModel )
    // Se ejecuta por cada fila del archivo excel
    public function model(array $row)
    {
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $out->writeln(".........");
        $this->current++;

        // Desde la 2da fila comienzan los datos
        if ($this->current > 1) {
            DB::beginTransaction();
            try {
                // Crear el usuario
                $usuario = new Usuarios();
                $usuario->nombre = $row[0];
                $usuario->apellidos = $row[1];
                $usuario->correo = $row[2];

                // Crear el vehículo
                $vehiculo = new Vehiculos();
                $vehiculo->marca = $row[3];
                $vehiculo->modelo = $row[4];
                $vehiculo->patente = $row[5];
                $vehiculo->anio = $row[6];
                $vehiculo->precio = $row[7];

                // Existe vehiculo?
                $vehiculoEncontrado = Vehiculos::where('patente', $vehiculo->patente)->first();
                if ($vehiculoEncontrado != null) {  // Si
                    // Mismo usuario?
                    // if ($vehiculoEncontrado->id_usuario == $usuario->id) {  // Si
                    //     // No se guarda
                    //     return;
                    // } else {
                    //     // Se actualiza la llave foránea del vehiculo
                    //     $vehiculoEncontrado->id_usuario = $usuario->id;
                    //     $vehiculoEncontrado->save();
                    //     DB::commit();
                    // }
                    // return;

                    $this->newMessage("El vehículo ya existe");
                    return;
                } else {  // No
                    // Existe usuario?
                    $usuarioEncontrado = Usuarios::where('correo', $usuario->correo)->first();

                    // Transformar objeto a texto
                    // $out->writeln(print_r($usuarioEncontrado, true));
                    if ($usuarioEncontrado != null) {  // Si
                        // El usuario ya está en bd asi que solo se guarda el vehiculo con el id del usuario
                        $vehiculo->id_usuario = $usuarioEncontrado->id;
                        $vehiculo->save();
                        DB::commit();
                        return;
                    } else {  // No
                        $vehiculo->id_usuario = $usuario->id;

                        // Ambos no existen asi que se guardan
                        $usuario->save();
                        $vehiculo->save();
                        DB::commit();
                        return;
                    }
                }
                return;
            } catch (\Exception $e) {
                DB::rollBack();
                $this->newMessage("El usuario y vehículo ya existen");
            }
        }
    }
}
