<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Historicos extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['id_usuario', 'id_vehiculo', 'fecha_inicio'];
    protected $dateFormat = 'Y-m-d H:i:s';

    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'id_usuario', 'id');
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculos::class, 'id_vehiculo', 'id');
    }
}
