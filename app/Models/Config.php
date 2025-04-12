<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;
    protected $table = 'configs';

    protected $guarded = [];

    /**
     * Relación: La configuración pertenece a un usuario.
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

    public static function getYear()
    {
        return self::find(1)->year ?? null;
    }
}
