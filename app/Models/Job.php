<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $table = 'jobs';

    protected $guarded = [];

    /**
     * Relación: El Job pertenece a un Motor.
     */
    public function motor()
    {
        return $this->belongsTo(\App\Models\Motor::class, 'id_motor', 'id_motor');
    }

    public function getFullOsAttribute()
    {
        return $this->year . "-" . str_pad($this->os, 4, '0', STR_PAD_LEFT);
    }
    /**
     * Relación: El Job pertenece a un JobType.
     */
    public function jobType()
    {
        return $this->belongsTo(\App\Models\JobType::class, 'job_type_id', 'id');
    }

    /**
     * Relación polimórfica: Un Job puede tener muchas imágenes.
     */
    public function images()
    {
        return $this->morphMany(\App\Models\Image::class, 'imageable');
    }
    public function assignments()
    {
        return $this->hasMany(\App\Models\JobAssigned::class, 'job_id', 'id');
    }
    public function usersAssigned()
    {
        return $this->belongsToMany(\App\Models\User::class, 'jobs_assigned', 'job_id', 'user_id')
            ->withPivot('assigned_by')
            ->withTimestamps();
    }
}
