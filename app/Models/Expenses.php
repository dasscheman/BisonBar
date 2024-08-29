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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        $status = new Status;
        return $status->getStatusOptions()[$this->status_id];
    }

    public function getStatusOptions()
    {
        $status = new Status;
        return $status->getStatusOptions();
    }

}
