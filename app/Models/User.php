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
        'userType',
        'id_cliente',
        'activo',
        'last_login_at',
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
        'last_login_at' => 'datetime',
    ];

    public const DEVELOPER = '1';
    public const GERENCIA = '2';
    public const ADMINISTRACION = '3';
    public const BODEGA = '4';
    public const TORNOS = '5';
    public const TECNICO = '6';
    public const AYUDANTES = '7';
    public const PRUEBAS = '8';
    public const PILOTOS = '9';
    public const VENDEDORES = '10';
    public const JEFE = '11';
    public const PINTURA = '12';
    public const CLIENTE = '13';

    public const ROLE_LABELS = [
        self::DEVELOPER => 'Developer',
        self::GERENCIA => 'Gerencia',
        self::ADMINISTRACION => 'Administración',
        self::BODEGA => 'Bodega',
        self::TORNOS => 'Tornos',
        self::TECNICO => 'Técnico',
        self::AYUDANTES => 'Ayudante',
        self::PRUEBAS => 'Pruebas',
        self::PILOTOS => 'Piloto',
        self::VENDEDORES => 'Vendedor',
        self::JEFE => 'Jefe',
        self::PINTURA => 'Pintura',
        self::CLIENTE => 'Cliente',
    ];

    public const ROLE_TOOLS = [
        self::DEVELOPER => [
            'Acceso total al sistema',
            'Administrar usuarios',
            'Configurar permisos',
            'Ver reportes técnicos',
            'Editar información de motores',
            'Crear cotizaciones',
            'Ver producción',
            'Administrar tableros',
        ],

        self::GERENCIA => [
            'Ver reportes generales',
            'Ver producción',
            'Ver cotizaciones',
            'Ver información de clientes',
            'Revisar indicadores',
        ],

        self::ADMINISTRACION => [
            'Administrar clientes',
            'Crear cotizaciones',
            'Ver documentos',
            'Gestionar información administrativa',
        ],

        self::BODEGA => [
            'Ver inventario',
            'Gestionar materiales',
            'Ver materiales pedidos',
            'Actualizar entregas',
        ],

        self::TORNOS => [
            'Ver trabajos asignados',
            'Registrar avances de torno',
            'Actualizar trabajos de mecanizado',
            'Ver información técnica del motor',
        ],

        self::TECNICO => [
            'Ver motores asignados',
            'Registrar bitácoras',
            'Subir fotografías',
            'Registrar pruebas',
            'Actualizar avances técnicos',
        ],

        self::AYUDANTES => [
            'Ver trabajos asignados',
            'Registrar apoyo en trabajos',
            'Subir fotografías',
        ],

        self::PRUEBAS => [
            'Registrar pruebas eléctricas',
            'Registrar temperaturas',
            'Registrar pruebas en vacío',
            'Ver historial de pruebas',
        ],

        self::PILOTOS => [
            'Ver envíos asignados',
            'Actualizar entregas',
            'Registrar movimientos',
        ],

        self::VENDEDORES => [
            'Ver clientes',
            'Crear cotizaciones',
            'Ver seguimiento comercial',
        ],

        self::JEFE => [
            'Ver trabajos del equipo',
            'Asignar trabajos',
            'Revisar producción',
            'Autorizar avances',
        ],

        self::PINTURA => [
            'Ver trabajos asignados',
            'Registrar avance de pintura',
            'Subir fotografías de pintura',
        ],

        self::CLIENTE => [
            'Ver sus motores',
            'Ver reportes autorizados',
            'Descargar documentos disponibles',
        ],
    ];

    public const PERMISSION_LABELS = [
        'cotizaciones.ver' => 'Ver cotizaciones',
        'cotizaciones.crear' => 'Crear cotizaciones',
        'cotizaciones.unificar' => 'Unificar cotizaciones',
    ];

    public const ROLE_PERMISSIONS = [
        self::DEVELOPER => [
            'cotizaciones.ver',
            'cotizaciones.crear',
            'cotizaciones.unificar',
        ],

        self::GERENCIA => [
            'cotizaciones.ver',
            'cotizaciones.crear',
            'cotizaciones.unificar',
        ],

        self::ADMINISTRACION => [
            'cotizaciones.ver',
            'cotizaciones.crear',
            'cotizaciones.unificar',
        ],
    ];

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
    public function jobsProduccion($initial_date, $final_date)
    {
        return $this->jobsAssigned()
            ->whereBetween('finished', [$initial_date, $final_date])
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


    public function jobsAssignedByMe()
    {
        return $this->hasMany(\App\Models\JobAssigned::class, 'assigned_by', 'id');
    }
    public function jobsAssigned()
    {
        return $this->belongsToMany(\App\Models\Job::class, 'jobs_assigned', 'user_id', 'job_id')
            ->withPivot('assigned_by')
            ->withTimestamps();
    }
    public function config()
    {
        return $this->hasOne(\App\Models\Config::class, 'user_id', 'id');
    }
    public function noLoadTests()
    {
        return $this->hasMany(\App\Models\NoLoadTest::class, 'id_user_test', 'id');
    }
    public function getRoleNameAttribute()
    {
        return self::ROLE_LABELS[$this->userType] ?? 'Sin rol asignado';
    }

    public function getRoleToolsAttribute()
    {
        return self::ROLE_TOOLS[$this->userType] ?? [];
    }

    public function hasRole($roles)
    {
        if (! is_array($roles)) {
            $roles = [$roles];
        }

        return in_array($this->userType, $roles);
    }
    public function permissions()
    {
        return self::ROLE_PERMISSIONS[$this->userType] ?? [];
    }

    public function canUse($permission)
    {
        return in_array($permission, $this->permissions());
    }

    public function getPermissionLabelsAttribute()
    {
        return collect($this->permissions())
            ->map(function ($permission) {
                return self::PERMISSION_LABELS[$permission] ?? $permission;
            })
            ->values()
            ->toArray();
    }
}
