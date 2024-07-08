<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Usuarios;
use App\Models\Vehiculos;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Output\ConsoleOutput;
use App\Models\Historicos;

class ExcelImport implements ToModel
{
    private $current = 0;
    private $messages = [];
    private $output;

    public function __construct()
    {
        $this->output = new ConsoleOutput();
    }

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

    // Obtiene la cantidad de filas leidas
    public function getLines()
    {
        return $this->current;
    }

    // Debe llamarse model para que funcione (Viene de ToModel )
    // Se ejecuta por cada fila del archivo excel
    public function model(array $row)
    {
        $this->output->writeln('Fila: ' . $row[0] . ' ' . $row[1] . ' ' . $row[2] . ' ' . $row[3] . ' ' . $row[4] . ' ' . $row[5] . ' ' . $row[6] . ' ' . $row[7]);
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
                    $this->newMessage("El vehículo ya está registrado");
                    DB::rollBack();
                    return null;
                } else {  // No
                    $historico = new Historicos();
                    // Existe usuario?
                    $usuarioEncontrado = Usuarios::where('correo', $usuario->correo)->first();
                    if ($usuarioEncontrado != null) {  // Si
                        $this->output->writeln("Usuario existente encontrado. Asociando vehículo al usuario.");
                        // El usuario ya está en bd asi que solo se guarda el vehiculo con el id del usuario
                        $vehiculo->id_usuario = $usuarioEncontrado->id;
                        $historico->id_usuario = $usuarioEncontrado->id;
                    } else {  // No
                        $this->output->writeln("Usuario y vehículo nuevos. Guardando ambos.");
                        // Ambos no existen asi que se guardan
                        $usuario->save();  // Aqui se obtiene su nuevo id
                        $historico->id_usuario = $usuario->id;
                        $vehiculo->id_usuario = $usuario->id;
                    }
                    $vehiculo->save();
                    $historico->id_vehiculo = $vehiculo->id;
                    $historico->fecha_inicio = date('Y-m-d H:i:s');
                    $historico->save();
                    DB::commit();
                    return null;
                }
            } catch (\Exception $e) {
                DB::rollBack();
                $this->newMessage("No se pudo guardar los datos: " . $e->getMessage());
            }
        }
    }
}
