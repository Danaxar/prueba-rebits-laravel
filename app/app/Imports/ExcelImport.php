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


    // Debe llamarse model para que funcione (Viene de ToModel )
    // Se ejecuta por cada fila del archivo excel
    public function model(array $row)
    {
        $this->current++;

        // Desde la 2da fila comienzan los datos
        if ($this->current > 1) {
            DB::beginTransaction();
            // Crear el usuario
            $usuario = new Usuarios();
            $usuario->nombre = $row[0];
            $usuario->apellidos = $row[1];
            $usuario->correo = $row[2];

            // Guardar el usuario
            try {
                if ($usuario->save()) {  // Retorna boolean -> true si se guardó, false si no
                    // Crear el vehículo
                    $vehiculo = new Vehiculos();
                    $vehiculo->marca = $row[3];
                    $vehiculo->modelo = $row[4];
                    $vehiculo->patente = $row[5];
                    $vehiculo->anio = $row[6];
                    $vehiculo->precio = $row[7];
                    $vehiculo->id_usuario = $usuario->id;
                    $vehiculo->save();
                    DB::commit();

                    // Mensaje de éxito
                    $this->newMessage("Usuario y vehículo guardados correctamente en la fila " . $this->current . "<br>");
                } else {
                    DB::rollBack();
                    $this->newMessage("El usuario ya existe en la fila " . $this->current);
                }
            } catch (\Exception $e) {
                DB::rollBack();
                $this->newMessage("Error en la fila " . $this->current . ": " . $e->getMessage());
            }

            // Retornar el modelo del usuario (necesario para ToModel)
            return $usuario;
        }
    }
}
