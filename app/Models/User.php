<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public const DEVELOPER = '1';
    public const ADMIN = '2';
    public const OFICINA = '3';
    public const ALMACEN = '4';
    public const PRUEBAS = '5';
    public const TECNICO = '6';
    public const TORNOS = '7';

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function usuario()
    {
        return $this->hasOne(Usuario::class, 'id_user', 'id');
    }

    public function motors()
    {
        return $this->belongsToMany(Motor::class, 'asignacions', 'id_user', 'id_motor')
            ->withPivot('asignado_por', 'responsabilidad')
            ->withTimestamps();
    }
    public function bitacoras()
    {
        return $this->hasMany(Bitacora::class, 'id_usuario');
    }

    public function documentos()
    {
        return $this->hasMany(Documento::class, 'id_user');
    }

    public function materialesPedidos()
    {
        return $this->hasMany(MaterialesPedido::class, 'id_user');
    }
}
