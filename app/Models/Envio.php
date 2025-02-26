<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Envio extends Model
{
    use HasFactory;

    // Especificamos el nombre de la tabla
    protected $table = 'envios';

    // Campos asignables de forma masiva
    protected $fillable = [
        'fecha',
        'tipo_vehiculo',
        'placa_vehiculo',
        'nombre_piloto',
        'dpi_piloto',
        'tipo_envio',
        'id_motor',
        'comentarios', 
    ];

    /**
     * Relación: un Envio pertenece a un Motor.
     */
    public function motor()
    {
        return $this->belongsTo(Motor::class, 'id_motor', 'id_motor');
    }

    public function enviosAdicionales()
    {
        return $this->hasMany(\App\Models\EnvioAdicional::class, 'envio_id', 'id');
    }
}
