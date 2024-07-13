<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'la_payments';

    const ADDSUBTRACT_SUBTRACT = 1;
    const ADDSUBTRACT_ADD = 2;

    protected $fillable = [
        'id',
        'user_id',
        'receipt_id',
        'invoice_id',
        'name',
        'description',
        'price',
        'add_subtract',
        'type_id' ,
        'status_id' ,
        'mollie_status',
        'mollie_id',
        'transaction_key',
        'transaction_cost',
        'created_at',
        'updated_at'
    ];
}
