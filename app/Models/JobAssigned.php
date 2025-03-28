<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobAssigned extends Model
{
    use HasFactory;
    protected $table = 'jobs_assigned';

    protected $fillable = [
        'user_id',
        'job_id',
        'assigned_by',
    ];

    /**
     * Relación: El registro pertenece al usuario asignado (a quien se le asignó el job).
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

    /**
     * Relación: El registro pertenece al job.
     */
    public function job()
    {
        return $this->belongsTo(\App\Models\Job::class, 'job_id', 'id');
    }

    /**
     * Relación: El registro pertenece al usuario que asignó el job.
     */
    public function assignedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'assigned_by', 'id');
    }
}
