<?php

namespace Tests\Feature;

use App\Models\Usuarios;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use \Symfony\Component\Console\Output\ConsoleOutput;


class ExcelImportTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function importExcel()
    {
        $out = new ConsoleOutput();
        $out->writeln("Creando usuario predefinido");

        $usuarioPredefinido = new Usuarios();
        $usuarioPredefinido->nombre = 'Daniel';
        $usuarioPredefinido->apellidos = 'Catalán';
        $usuarioPredefinido->correo = 'daniel.catalan@usach.cl';

        DB::beginTransaction();
        $usuarioPredefinido->save();
        DB::commit();

        // Ruta al archivo de prueba
        $filePath = base_path('excelsPruebas/vehiculos_usuarios.xlsx');

        // Simula la carga del archivo
        $file = new UploadedFile(
            $filePath,
            'vehiculos_usuarios.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );  //! Aqui se cae

        // Envía una solicitud POST al endpoint con el archivo
        $response = $this->postJson('/api/excel/upload', [
            'file' => $file,
        ]);

        // Verifica que la respuesta tenga el formato esperado
        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
            ]);

        // Opcional: Verifica otros aspectos de la respuesta
        $responseData = $response->json();
        $this->assertIsArray($responseData['messages']);
        $this->assertIsInt($responseData['rows']);
    }
}
