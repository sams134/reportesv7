<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CotizacionEncamisadoPrecio extends Model
{
    protected $table = 'cotizacion_encamisado_precios';

    protected $fillable = [
        'tamanio_minimo',
        'tamanio_maximo',
        'precio',
        'activo',
    ];

    protected $casts = [
        'tamanio_minimo' => 'decimal:2',
        'tamanio_maximo' => 'decimal:2',
        'precio' => 'decimal:2',
        'activo' => 'boolean',
    ];

    public function scopeBuscarPrecio($query, $diametro)
    {
        return $query->where('activo', 1)
            ->where('tamanio_minimo', '<=', $diametro)
            ->where('tamanio_maximo', '>=', $diametro)
            ->orderByDesc('tamanio_minimo');
    }
}