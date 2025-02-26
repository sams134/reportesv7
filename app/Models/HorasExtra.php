<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorasExtra extends Model
{
    use HasFactory;
    protected $table = 'horas_extras';

    protected $guarded = [];

    /**
     * Relación: Un registro de horas extras pertenece a un motor.
     */
    public function motor()
    {
        return $this->belongsTo(Motor::class, 'id_motor', 'id_motor');
    }

    /**
     * Relación: Un registro de horas extras pertenece al usuario que lo solicitó.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Relación: Un registro de horas extras pertenece al usuario que autorizó (puede ser distinto).
     */
    public function autorizadoPor()
    {
        return $this->belongsTo(User::class, 'autorizado_por', 'id');
    }
}
