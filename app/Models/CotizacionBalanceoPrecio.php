<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CotizacionBalanceoPrecio extends Model
{
    protected $table = 'cotizacion_balanceo_precios';

    protected $fillable = [
        'limite_inferior_hp',
        'limite_superior_hp',
        'polos',
        'precio_aprox',
        'activo',
    ];

    protected $casts = [
        'limite_inferior_hp' => 'decimal:2',
        'limite_superior_hp' => 'decimal:2',
        'precio_aprox' => 'decimal:2',
        'activo' => 'boolean',
    ];

    public function scopeBuscarPrecio($query, $hp, $polos)
    {
        return $query->where('activo', 1)
            ->where('limite_inferior_hp', '<=', $hp)
            ->where('limite_superior_hp', '>=', $hp)
            ->where('polos', $polos);
    }
}