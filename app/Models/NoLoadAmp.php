<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoLoadAmp extends Model
{
    use HasFactory;
     /**
     * La tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'no_load_amps';

    /**
     * La clave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicamos que la tabla no tiene columnas created_at / updated_at.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $guarded = ['id'];
}
