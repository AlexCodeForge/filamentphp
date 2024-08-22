<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'country_id',
        'state_id',
        'city_id',
        'address',
        'postal_code',
    ];

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
        'password' => 'hashed',
    ];

    public function country(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function calendars(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Calendar::class);
    }
    public function departments(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Departament::class);
    }

    public function holidays(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Holiday::class);
    }

    public function timesheets(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Timesheet::class);
    }

}
