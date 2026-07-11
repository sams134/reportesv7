<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CotizacionExcelGrupo extends Model
{
    protected $table = 'cotizacion_excel_grupos';

    protected $guarded = [];

    protected $casts = [
        'datos_tecnicos_json' => 'array',
        'subtotal' => 'decimal:2',
    ];

    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class, 'cotizacion_id', 'id');
    }

    public function items()
    {
        return $this->hasMany(CotizacionItem::class, 'cotizacion_excel_grupo_id', 'id')
            ->orderBy('orden');
    }
}