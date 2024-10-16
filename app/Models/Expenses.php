<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expenses extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'la_expenses';

    protected $fillable = [
        'id',
        'user_id',
        'receipt_id',
        'invoice_id',
        'description',
        'price',
        'status_id',
        'created_at',
        'updated_at',
    ];
}
