<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CotizacionItem extends Model
{
    protected $table = 'cotizacion_items';

    protected $fillable = [
        'cotizacion_id',
        'cotizacion_excel_grupo_id',
        'catalogo_item_id',
        'nombre',
        'descripcion',
        'cantidad',
        'precio_unitario',
        'precio_total',
        'orden',
        'cotizacion_unificada_detalle_id',
        'cotizacion_origen_item_id',
        'tipo_item',
        'descuento_porcentaje',
        'descuento_alcance',
        'descuento_item_principal_uid',
    ];

    protected $casts = [
        'cantidad' => 'decimal:2',
        'precio_unitario' => 'decimal:2',
        'precio_total' => 'decimal:2',
    ];

    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class, 'cotizacion_id');
    }

    public function catalogoItem()
    {
        return $this->belongsTo(CotizacionCatalogoItem::class, 'catalogo_item_id');
    }
    public function excelGrupo()
    {
        return $this->belongsTo(CotizacionExcelGrupo::class, 'cotizacion_excel_grupo_id', 'id');
    }
}
