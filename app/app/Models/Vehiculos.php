<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehiculos extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['marca', 'modelo', 'patente', 'anio', 'precio', 'id_usuario'];
    protected $dateFormat = 'Y-m-d H:i:s';

    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'id_usuario', 'id');
    }
}
