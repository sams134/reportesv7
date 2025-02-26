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
    public const AYUDANTES = '8';

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
    public function looks()
    {
        return $this->belongsToMany(
            \App\Models\Motor::class,
            'looks',       // Tabla pivot
            'user_id',     // Clave foránea en la tabla pivot para este modelo (User)
            'motor_id'     // Clave foránea en la tabla pivot para el modelo relacionado (Motor)
        )->withTimestamps();
    }
    // Horas extras solicitadas por el usuario
    public function horasExtrasSolicitadas()
    {
        return $this->hasMany(HorasExtra::class, 'user_id', 'id');
    }

    // Horas extras autorizadas por el usuario
    public function horasExtrasAutorizadas()
    {
        return $this->hasMany(HorasExtra::class, 'autorizado_por', 'id');
    }
    public function otherWorks()
    {
        return $this->hasMany(\App\Models\OtherWork::class, 'user_id', 'id');
    }

    // horas extras entre initial date y final date
    public function horasExtras($initial_date, $final_date)
    {
        return HorasExtra::where('user_id', $this->id)
            ->where('init', '>=', $initial_date)
            ->where('final', '<=', $final_date)
            ->get();
    }
    public function produccion($initial_date, $final_date)
    {
        return $this->motors()
            ->whereBetween('fin', [$initial_date, $final_date])
            ->get();
    }
    public function otherWorksProduccion($initial_date, $final_date)
    {
        return $this->otherWorks()
            ->whereBetween('fecha', [$initial_date, $final_date])
            ->get();
    }
    public function boards()
    {
        return $this->hasMany(\App\Models\Board::class, 'owner_id', 'id');
    }
    public function sharedBoards()
    {
        return $this->belongsToMany(
            \App\Models\Board::class,
            'shared_boards',  // Tabla pivot
            'user_id',        // Clave foránea en la tabla pivot para User
            'board_id'        // Clave foránea en la tabla pivot para Board
        )->withTimestamps();
    }
    public function pins()
    {
        return $this->hasMany(Pin::class);
    }
}
