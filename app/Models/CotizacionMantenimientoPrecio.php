<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CotizacionMantenimientoPrecio extends Model
{
    protected $table = 'cotizacion_mantenimiento_precios';

    protected $fillable = [
        'limite_inferior_hp',
        'limite_superior_hp',
        'polos',
        'precio_aprox',
        'voltaje_max',

        'costo_pruebas_estator',

        'costo_trabajos_motor_completo',
        'costo_pruebas_motor_completo',

        'costo_trabajos_reductora',
        'costo_pruebas_reductora',

        'costo_trabajos_bomba',
        'costo_pruebas_bomba',

        'costo_trabajos_ventilador',
        'costo_pruebas_ventilador',

        'costo_trabajos_maquina',
        'costo_pruebas_maquina',

        'activo',
    ];

    protected $casts = [
        'limite_inferior_hp' => 'decimal:2',
        'limite_superior_hp' => 'decimal:2',
        'precio_aprox' => 'decimal:2',
        'voltaje_max' => 'decimal:2',

        'costo_pruebas_estator' => 'decimal:2',

        'costo_trabajos_motor_completo' => 'decimal:2',
        'costo_pruebas_motor_completo' => 'decimal:2',

        'costo_trabajos_reductora' => 'decimal:2',
        'costo_pruebas_reductora' => 'decimal:2',

        'costo_trabajos_bomba' => 'decimal:2',
        'costo_pruebas_bomba' => 'decimal:2',

        'costo_trabajos_ventilador' => 'decimal:2',
        'costo_pruebas_ventilador' => 'decimal:2',

        'costo_trabajos_maquina' => 'decimal:2',
        'costo_pruebas_maquina' => 'decimal:2',

        'activo' => 'boolean',
    ];

    public function scopeBuscarPrecio($query, $hp, $polos, $voltaje = null)
    {
        $query->where('activo', 1)
            ->where('limite_inferior_hp', '<=', $hp)
            ->where('limite_superior_hp', '>=', $hp)
            ->where('polos', $polos);

        if ($voltaje) {
            $query->where('voltaje_max', '>=', $voltaje)
                ->orderBy('voltaje_max', 'asc');
        } else {
            $query->orderBy('voltaje_max', 'asc');
        }

        return $query;
    }
}