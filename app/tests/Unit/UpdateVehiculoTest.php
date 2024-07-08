<?php

namespace Tests\Unit;

use App\Models\Historicos;
use App\Models\Vehiculos;
// use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use App\Models\Usuarios;
use Illuminate\Support\Facades\DB;
use \Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Foundation\Testing\RefreshDatabase;


class UpdateVehiculoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function updateDueno(): void
    {
        $out = new ConsoleOutput();
        // Datos iniciales: un usuario con auto
        $usuario = new Usuarios();
        $usuario->nombre = 'Juan';
        $usuario->apellidos = 'Perez';
        $usuario->correo = 'juan.perez@example.com';
        DB::beginTransaction();
        $usuario->save();
        DB::commit();

        $vehiculo = new Vehiculos();
        $vehiculo->patente = 'ABC123';
        $vehiculo->marca = 'Ford';
        $vehiculo->modelo = 'Fiesta';
        $vehiculo->anio = 2020;
        $vehiculo->precio = 1000000;
        $vehiculo->id_usuario = $usuario->id;
        DB::beginTransaction();
        $vehiculo->save();
        DB::commit();

        $historico = new Historicos();
        $historico->id_vehiculo = $vehiculo->id;
        $historico->id_usuario = $usuario->id;
        $historico->fecha_inicio = date('Y-m-d H:i:s');
        DB::beginTransaction();
        $historico->save();
        DB::commit();

        // Se crea un nuevo dueño para el auto
        $usuarioNuevo = new Usuarios();
        $usuarioNuevo->nombre = 'Pedro';
        $usuarioNuevo->apellidos = 'Gomez';
        $usuarioNuevo->correo = 'pedro.gomez@example.com';

        // Llamar a endpoint 
        $response = $this->postJson('/api/vehiculos/nuevoDueno', [
            'usuario' => $usuarioNuevo,
            'vehiculo' => $vehiculo
        ]);

        // Verifica que la respuesta tenga el formato esperado
        $response->assertStatus(200);

        $out->writeln('Prueba finalizada con exito');
    }
}
