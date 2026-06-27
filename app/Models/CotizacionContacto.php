<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CotizacionContacto extends Model
{
    protected $table = 'cotizacion_contactos';

    protected $fillable = [
        'cotizacion_id',
        'contacto_id',
        'nombre',
        'puesto',
        'telefono',
        'email',
    ];

    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class, 'cotizacion_id');
    }

    public function contacto()
    {
        return $this->belongsTo(Contacto::class, 'contacto_id');
    }
}