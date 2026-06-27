<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CotizacionCatalogoItem extends Model
{
    protected $table = 'cotizacion_catalogo_items';

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'tipo',
        'categoria',
        'es_accion',
        'es_rapido',
        'activo',
        'orden',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'es_accion' => 'boolean',
        'es_rapido' => 'boolean',
        'activo' => 'boolean',
    ];

    public function cotizacionItems()
    {
        return $this->hasMany(CotizacionItem::class, 'catalogo_item_id');
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', 1);
    }

    public function scopeRapidos($query)
    {
        return $query->where('activo', 1)
            ->where('es_accion', 0)
            ->where('es_rapido', 1)
            ->orderBy('orden');
    }

    public function scopeBuscando($query, $search)
    {
        return $query->where('activo', 1)
            ->where('es_accion', 0)
            ->where('es_rapido', 0)
            ->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('descripcion', 'like', "%{$search}%")
                    ->orWhere('categoria', 'like', "%{$search}%");
            })
            ->orderBy('nombre');
    }
}
