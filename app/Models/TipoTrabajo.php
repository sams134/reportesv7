<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoTrabajo extends Model
{
    use HasFactory;

    protected $table = 'tipo_trabajos';

    protected $fillable = [
        'name',
    ];

    /**
     * Relación: Un TipoTrabajo puede estar asociado a muchos Motores.
     */
    public function motors()
    {
        return $this->hasMany(\App\Models\Motor::class, 'id_trabajo', 'id');
    }
}
