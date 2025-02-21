<?php

namespace App\Models;

ini_set('memory_limit', -1);

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'user_type',
        'is_factory_user',
        'picture',
        'status',
        'business_email',
        'business_name',
        'address',
        'postal_code',
        'business_phone',
        'country',
        'invoice_template',
        'per_page',
        'custom_note',
        'custom_note_heading',
        'logo',
    ];

    protected $dates = ['last_login_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relationship to UserRole model.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Determine if $this has a specific role.
     *
     * @param  \Illuminate\Support\Collection}string  $role
     * @return bool
     */
    public function is($role)
    {
        foreach (collect($role) as $r) {
            if ($this->roles->contains('role', $r)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Relationship with the Activity model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function modelActivities()
    {
        return $this->morphMany(Activity::class, 'model');
    }

    public function orders()
    {
        return $this->hasMany(Sale::class);
    }
}
