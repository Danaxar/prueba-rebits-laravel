<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usuarios extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['nombre', 'apellidos', 'correo'];
    protected $dateFormat = 'Y-m-d H:i:s';

    public function vehiculos()
    {
        return $this->hasMany(Vehiculos::class, 'id', 'id');
    }
}
