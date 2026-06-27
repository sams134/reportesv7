<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CotizacionTextoPresentacion extends Model
{
    protected $table = 'cotizacion_textos_presentacion';

    protected $fillable = [
        'titulo',
        'slug',
        'contenido',
        'activo',
        'orden',
    ];
}