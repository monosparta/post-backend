<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
// use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasTeams;
use MohamedGaber\SanctumRefreshToken\Traits\HasApiTokens;

class AdminUser extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use UuidTrait;

    public const baseValidator = [
        'name' => 'required|string',
        'first_name' => 'nullable|string',
        'last_name' => 'nullable|string',
        'remark' => 'nullable|string',
    ];

    protected $keyType = 'char';

    protected $dates = [
        'last_login_at',
        'offline_at',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'first_name',
        'last_name',
        'full_name',
        'last_login_at',
        'remark',
    ];

    protected $guarded = [
        'password',
    ];

    protected $visible = [
        'id',
        'name',
        'email',
        'first_name',
        'last_name',
        'full_name',
        'remark',
        'created_at',
        'updated_at',
        'last_login_at',
    ];

    // use CastsEnums;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'last_login_at' => 'datetime',
        'offline_at' => 'datetime',
    ];
}
