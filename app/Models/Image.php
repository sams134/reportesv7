<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'comentario',
        'imageable_id',
        'imageable_type',
        'user_id',
    ];

    /**
     * Relación polimórfica.
     */
    public function imageable()
    {
        return $this->morphTo();
    }
}
