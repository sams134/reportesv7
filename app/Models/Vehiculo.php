<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    use HasFactory;
    protected $table = 'vehiculos';

    // Los campos que se pueden asignar de forma masiva
    protected $fillable = [
        'name',
        'tipo',
        'placa',
    ];

}
