<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CotizacionPruebaPrecio extends Model
{
    protected $table = 'cotizacion_prueba_precios';

    protected $fillable = [
        'cliente_id',
        'cliente_nombre',
        'cotizacion_id',
        'prueba_tipo',
        'ubicacion',
        'tension_tipo',
        'hp',
        'voltaje',
        'cantidad_equipos',
        'nombre',
        'descripcion',
        'precio_unitario',
        'precio_total',
        'moneda',
        'activo',
    ];

    protected $casts = [
        'hp' => 'decimal:2',
        'voltaje' => 'decimal:2',
        'cantidad_equipos' => 'integer',
        'precio_unitario' => 'decimal:2',
        'precio_total' => 'decimal:2',
        'activo' => 'boolean',
    ];
}