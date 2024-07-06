<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Usuarios;
use App\Models\Vehiculos;

class ExcelImport implements ToCollection, ToModel
{
    private $current = 0;

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
    }

    public function model(array $row)
    {
        $this->current++;
        if ($this->current > 1) {
            $usuario = new Usuarios();
            $usuario->nombre = $row[0];
            $usuario->apellidos = $row[1];
            $usuario->correo = $row[2];
            $usuario->save();
        }
    }
}
