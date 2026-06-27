<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CotizacionRodamientoPrecio extends Model
{
    protected $table = 'cotizacion_rodamiento_precios';

    protected $fillable = [
        'codigo_base',
        'serie',
        'marca',
        'sellos',
        'jaula',
        'juego_radial',
        'aislamiento',
        'designacion',
        'precio',
        'moneda',
        'veces_usado',
        'activo',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'veces_usado' => 'integer',
        'activo' => 'boolean',
    ];
}