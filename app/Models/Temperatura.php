<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temperatura extends Model
{
    use HasFactory;
    protected $table = 'temperaturas';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function motor()
    {
        return $this->belongsTo(Motor::class, 'id_motor', 'id_motor');
    }
}
