<?php

namespace App\Models;


use Barryvdh\DomPDF\Facade\Pdf;
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
        return $this->hasMany(Expenses::class, 'user_id');
    }

    public function expensesNotInvoiced()
    {
        return $this->expenses()
            ->whereNull('invoice_id');
    }


    public function paymentsAddNotInvoiced($type)
    {
        return $this->paymentsAdd($type)
            ->whereNull('invoice_id');
    }

    public function paymentsAdd($type): HasMany
    {
        return $this->hasMany(Payment::class, 'user_id')
            ->where('type_id', $type)
            ->where('add_subtract', Payment::ADDSUBTRACT_ADD);
    }


    public function paymentsSubtractNotInvoiced($type)
    {
        return $this->paymentsSubtract($type)
            ->whereNull('invoice_id');
    }


    public function paymentsSubtract($type): HasMany
    {
        return $this->hasMany(Payment::class, 'user_id')
            ->where('type_id', $type)
            ->where('add_subtract', Payment::ADDSUBTRACT_SUBTRACT);
    }

    public function talliesNotInvoiced(): HasMany
    {
        return $this->tallies()
            ->whereNull('invoice_id');
    }

    public function tallies(): HasMany
    {
        return $this->hasMany(Tally::class, 'user_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'user_id');
    }
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoices::class, 'user_id');
    }
}
