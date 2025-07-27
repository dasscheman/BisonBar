<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoices extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'la_invoices';

    public $invoicePath = 'storage/app/invoices/';

    protected $fillable = [
        'id',
        'user_id',
        'name',
        'file_name',
        'send_at',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tallies()
    {
        return $this->hasMany(Tally::class, 'invoice_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'invoice_id');
    }

    public function expenses()
    {
        return $this->hasMany(Expenses::class, 'invoice_id');
    }


    public function totalOnDate()
    {
        $user = User::where('id',  $this->user_id)->withTrashed()->first();
        $calculation = new Calculations($user);
        $calculation->setDate($this->created_at);
        return $calculation->total();
    }

    public function recalculate()
    {
        Payment::where('invoice_id', $this->id)->update(['status_id' => Status::STATUS_herberekend, 'invoice_id' => null]);
        Tally::where('invoice_id', $this->id)->update(['status_id' => Status::STATUS_herberekend, 'invoice_id' => null]);
        Expenses::where('invoice_id', $this->id)->update(['status_id' => Status::STATUS_herberekend, 'invoice_id' => null]);
    }

    public function genereateInvoice($calculations)
    {
        $calculations->paymentsNotInvoiced()->update(['status_id' => Status::STATUS_factuur_gegenereerd, 'invoice_id' => $this->id]);
        $calculations->talliesNotInvoiced()->update(['status_id' => Status::STATUS_factuur_gegenereerd, 'invoice_id' => $this->id]);
        $calculations->expensesNotInvoiced()->update(['status_id' => Status::STATUS_factuur_gegenereerd, 'invoice_id' => $this->id]);
    }

    public function sendInvoice()
    {
        Payment::where('invoice_id', $this->id)->update(['status_id' => Status::STATUS_factuur_verzonden]);
        Tally::where('invoice_id', $this->id)->update(['status_id' => Status::STATUS_factuur_verzonden]);
        Expenses::where('invoice_id', $this->id)->update(['status_id' => Status::STATUS_factuur_verzonden]);
    }
}
