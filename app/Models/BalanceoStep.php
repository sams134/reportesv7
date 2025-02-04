<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalanceoStep extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'balanceos_steps';

    // Clave primaria
    protected $primaryKey = 'id';

    // Indica si la clave primaria es auto-incremental
    public $incrementing = true;

    // Tipo de clave primaria
    protected $keyType = 'int';

    // Indica si las marcas de tiempo (timestamps) están habilitadas
    public $timestamps = false;

    // Lista de atributos que se pueden asignar masivamente
    protected $guarded = [];

    // Relación con el modelo Balanceo
    public function balanceo()
    {
        return $this->belongsTo(BalanceoStep::class, 'balanceo_id', 'id');
    }
}
