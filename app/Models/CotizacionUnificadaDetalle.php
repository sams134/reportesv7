<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CotizacionItem;

class CotizacionUnificadaDetalle extends Model
{
    protected $table = 'cotizacion_unificada_detalles';

    protected $guarded = [];

    public function cotizacionUnificada()
    {
        return $this->belongsTo(Cotizacion::class, 'cotizacion_unificada_id', 'id');
    }

    public function cotizacionOrigen()
    {
        return $this->belongsTo(Cotizacion::class, 'cotizacion_origen_id', 'id');
    }
    public function items()
    {
        return $this->hasMany(CotizacionItem::class, 'cotizacion_unificada_detalle_id', 'id')
            ->orderBy('orden');
    }
}
