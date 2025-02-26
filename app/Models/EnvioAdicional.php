<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnvioAdicional extends Model
{
    use HasFactory;

    protected $table = 'envios_adicionales';

    // Campos asignables de forma masiva
    protected $fillable = [
        'parte',
        'envio_id',
    ];

    /**
     * Relación: Un EnvioAdicional pertenece a un Envio.
     */
    public function envio()
    {
        return $this->belongsTo(Envio::class, 'envio_id', 'id');
    }
}
