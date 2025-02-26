<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SharedBoard extends Model
{
    use HasFactory;
    protected $table = 'shared_boards';

    protected $fillable = [
        'board_id',
        'user_id',
    ];

    /**
     * Relación: un SharedBoard pertenece a un Board.
     */
    public function board()
    {
        return $this->belongsTo(Board::class, 'board_id', 'id');
    }

    /**
     * Relación: un SharedBoard pertenece a un User.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
