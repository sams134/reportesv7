<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $primaryKey = 'id_contacto';

    public function cliente()
    {
        return $this->belongsTo(Cliente::class,'id_cliente');
    }
}
