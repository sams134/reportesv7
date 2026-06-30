<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MotorAdminStatusDocument extends Model
{
    protected $table = 'motor_admin_status_documents';

    protected $guarded = [];

    public function adminStatus()
    {
        return $this->belongsTo(MotorAdminStatus::class, 'motor_admin_status_id', 'id');
    }

    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by', 'id');
    }

    public function getUrlAttribute()
    {
        return asset('storage/' . ltrim($this->archivo_path, '/'));
    }

    public function getEsPdfAttribute()
    {
        return $this->mime_type === 'application/pdf';
    }

    public function getEsImagenAttribute()
    {
        return str_starts_with((string) $this->mime_type, 'image/');
    }
}