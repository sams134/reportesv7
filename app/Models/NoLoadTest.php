<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoLoadTest extends Model
{
    use HasFactory;

    use HasFactory;

    protected $table = 'no_load_test';

    // Si tu tabla tiene un id auto-increment
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    // Si usas timestamps
    public $timestamps = true;

   protected $guarded = [];

    /**
     * Relación con Motor
     */
    public function motor()
    {
        return $this->belongsTo(Motor::class, 'id_motor', 'id_motor');
    }

    /**
     * Relación con Usuario que hizo la prueba
     */
    public function userTest()
    {
        return $this->belongsTo(User::class, 'id_user_test', 'id');
    }
}
