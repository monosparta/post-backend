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

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use UuidTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'email', 'password', 'mobile_country_code', 'mobile_country_calling_code', 'mobile', 'full_name', 'custom_id',
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
        'two_factor_confirmed_at',
        'current_team_id',
        'profile_photo_path',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function organization()
    {
        return $this->hasOne(Organization::class);
    }

    public function address()
    {
        return $this->hasManyThrough(Address::class, UserProfile::class, 'user_id', 'addressable_id', 'id', 'id');
    }

    public function userCategories()
    {
        return $this->belongsToMany(UserCategory::class, 'user_user_categories');
    }

    public function emergencyContacts()
    {
        return $this->hasMany(EmergencyContact::class);
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
