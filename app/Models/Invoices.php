<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoices extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'la_invoices';

    protected $fillable = [
        'id',
        'id',
        'user_id',
        'name',
        'file_name',
        'send_at',
        'created_at',
        'updated_at',
    ];
}
