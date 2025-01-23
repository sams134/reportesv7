<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialesPedido extends Model
{
    use HasFactory;

    protected $table = 'materiales_pedidos';

    // Llave primaria
    protected $primaryKey = 'id';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'id_material',
        'material',
        'presentacion',
        'cantidad',
        'id_motor',
        'id_user',
        'despachado',
    ];

    // Relación con el modelo Motor
    public function motor()
    {
        return $this->belongsTo(Motor::class, 'id_motor');
    }

    // Relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
