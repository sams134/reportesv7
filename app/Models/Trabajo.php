<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trabajo extends Model
{
    use HasFactory;

    protected $table = 'trabajos';

    // Llave primaria
    protected $primaryKey = 'id';

    // Indicar si la llave primaria es auto incrementable
    public $incrementing = true;

    // Tipo de la llave primaria
    protected $keyType = 'int';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'id_motor',
        'trabajo',
        'cotizar',
        'autorizado',
        'fecha_autorizado',
        'fecha_iniciado',
        'fecha_finalizado',
        'precio_compra',
        'precio_venta',
        'place_order',
        'progress',
    ];

    // Relación con el modelo Motor
    public function motor()
    {
        return $this->belongsTo(Motor::class, 'id_motor');
    }

    public function fotosTrabajo()
    {
        return $this->hasMany(FotosTrabajo::class, 'id_trabajo');
    }
}
