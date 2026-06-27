<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CotizacionPdfAdjunto extends Model
{
    protected $table = 'cotizacion_pdfs_adjuntos';

    protected $guarded = [];

    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class, 'cotizacion_id', 'id');
    }
}