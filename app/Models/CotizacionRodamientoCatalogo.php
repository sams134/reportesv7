<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CotizacionRodamientoCatalogo extends Model
{
    protected $table = 'cotizacion_rodamientos_catalogo';

    protected $fillable = [
        'codigo',
        'serie',
        'diametro_exterior_mm',
        'activo',
        'orden',
    ];

    protected $casts = [
        'diametro_exterior_mm' => 'decimal:2',
        'activo' => 'boolean',
    ];

    public function scopeActivos($query)
    {
        return $query->where('activo', 1)
            ->orderBy('orden');
    }
}