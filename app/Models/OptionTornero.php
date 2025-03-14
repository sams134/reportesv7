<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionTornero extends Model
{
    use HasFactory;
    protected $table = 'options_tornero';

    protected $fillable = [
        'cuna_eje',
        'decision',
    ];
}
