<?php

namespace App\Models;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Lab404\Impersonate\Models\Impersonate;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, Impersonate;
    const ROLE_user = 1;
    const ROLE_bar_user = 2;
    const ROLE_admin = 3;
    const ROLE_super_admin = 4;


    protected $table = 'la_users';
    protected $key = 'id';

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
        'auto_payment_notice_at' => 'datetime',
    ];

    protected $fillable = [
        'id',
        'name',
        'role_id',
        'email',
        'password',
        'pay_key',
        'hard_limit',
        'rise_limit',
        'email_verified_at',
        'blocked_at',
        'last_login_at',
        'mollie_customer_id',
        'mollie_amount',
        'automatic_payment',
        'auto_payment_notice_at'
    ];

    /**
     * Retrieves a list of roles
     *
     * @return array an array of available roles.
     */
    public static function getRoleOptions()
    {
        return [
            self::ROLE_user => __('user'),
            self::ROLE_bar_user => __('bar_user'),
            self::ROLE_admin => __('admin'),
            self::ROLE_super_admin => __('super_admin_aka_daan'),
        ];
    }

    public function role()
    {
        return $this->getRoleOptions()[$this->role_id];
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        $query = $this->where('id', $value);

        $query->withoutGlobalScope(SoftDeletingScope::class);
        // Find the first record, or abort
        return $query->firstOrFail();
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expenses::class, 'user_id');
    }

    public function tallies(): HasMany
    {
        return $this->hasMany(Tally::class, 'user_id');
    }

    public function lastTally()
    {
        return $this->hasOne(Tally::class)->latest();
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'user_id');
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoices::class, 'user_id');
    }

    public function total()
    {
        $calculation = new Calculations($this);

        return $calculation->total();
    }

    public function totalAtDate($date)
    {
        $calculation = new Calculations($this);
        $calculation->setDate($date);
        return $calculation->total();
    }


    public static function findByPayKey($payKey)
    {
        return User::where('pay_key', $payKey)->first();
    }

    public function generateNewInvoice()
    {
        $last_invoice_id = Invoices::orderBy('id', 'desc')->withTrashed()->first()->id;
        $last_invoice_id++;
        $invoice = new Invoices;
        $invoice->user_id = $this->id;
        $invoice->name = $this->name.'_'.$last_invoice_id;
        $invoice->file_name = $this->name.'_TEMP.pdf';
        $invoice->save();
        $invoice->file_name = $this->name.'_'.$last_invoice_id.'.pdf';

        $calculations = new Calculations($this);
        $pdf = Pdf::loadView('pdf.invoice-template', ['user' => $this, 'calculations' => $calculations]);

        if (! $pdf->save($invoice->invoicePath.$invoice->file_name)) {
            return false;
        }

        DB::transaction(function () use($invoice, $calculations) {
            if (!$invoice->save()) {
                return false;
            }
            $invoice->genereateInvoice($calculations);
            return true;
        });

        return true;
    }

    /**
     * @return bool
     */
    public function canImpersonate()
    {
        // For example
        return $this->role_id == self::ROLE_super_admin;
    }
}
