<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function motors()
    {
        return $this->hasMany(Motor::class, 'status_id');
    }
}
