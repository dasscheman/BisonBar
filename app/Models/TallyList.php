<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TallyList extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'la_tally_lists';

    protected $fillable = [
        'id',
        'serial_number',
        'start_date',
        'end_date',
        'created_at',
        'updated_at',
    ];
}
