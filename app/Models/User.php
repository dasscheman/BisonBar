<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'la_users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'deleted_at' => 'datetime',
        'blocked_at' => 'datetime',
    ];

    public function expenses(): HasMany
    {
        return $this->hasMany(Expenses::class);
    }

    public function paymentsAdd(): HasMany
    {
        return $this->hasMany(Payment::class)
            ->where('add_subtract', 2);
    }

    public function paymentsSubtract(): HasMany
    {
        return $this->hasMany(Payment::class)
            ->where('add_subtract', 1);
    }

    public function tallies(): HasMany
    {
        return $this->hasMany(Tally::class);
    }

    public function total()
    {
        return $this->expenses->sum('price')
            + $this->paymentsAdd->sum('price')
            - $this->paymentsSubtract->sum('price')
            - $this->tallies->sum('price');
    }
}
