<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pin extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Relación polimórfica.
     */
    public function pinable()
    {
        return $this->morphTo();
    }
    public function board()
    {
        return $this->belongsTo(\App\Models\Board::class, 'board_id', 'id');
    }
}
