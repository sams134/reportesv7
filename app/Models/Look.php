<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Look extends Model
{
    use HasFactory;

    protected $table = 'looks';

    protected $fillable = [
        'motor_id',
        'user_id',
    ];
}
