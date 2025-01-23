<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;

    protected $table = 'inventarios';

    // Llave primaria
    protected $primaryKey = 'id';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'id_motor',
        'acople',
        'caja_conexiones',
        'tapa_caja',
        'difusor',
        'ventilador',
        'bornera',
        'cunia',
        'graseras',
        'cancamo',
        'placa',
        'capacitor',
        'tornillos',
        'comentarios',
    ];

    // Relación con el modelo Motor
    public function motor()
    {
        return $this->belongsTo(Motor::class, 'id_motor');
    }

    public function getItemStatus($item)
{
    $status = [
        1 => 'Si trae',
        2 => 'No trae',
        3 => 'No Aplica'
    ];
    return isset($status[$item]) ? $status[$item] : 'No definido';
}
}
