<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    use HasFactory;
    protected $table = 'boards';

    protected $fillable = [
        'name',
        'owner_id',
    ];

    /**
     * Relación: un Board pertenece a un User (el propietario).
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }
    public function sharedUsers()
    {
        return $this->belongsToMany(
            \App\Models\User::class,
            'shared_boards',   // Tabla pivot
            'board_id',        // Clave foránea en la tabla pivot para Board
            'user_id'          // Clave foránea en la tabla pivot para User
        )->withTimestamps();
    }
    public function pins()
    {
        return $this->hasMany(\App\Models\Pin::class, 'board_id', 'id');
    }
}
