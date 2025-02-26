<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherWork extends Model
{
    use HasFactory;
    protected $table = 'other_works';

    // Campos asignables
    protected $fillable = [
        'descripcion',
        'fecha',
        'pago',
        'user_id',
    ];

    /**
     * Relación: Un OtherWork pertenece a un User.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
