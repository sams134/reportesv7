<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Info_cliente extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $primaryKey = 'id';

    // Indicar si la llave primaria es auto incrementable
    public $incrementing = true;

    // Tipo de la llave primaria
    protected $keyType = 'int';

    protected $table = 'info_clientes';


    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id_cliente');
    }
}
