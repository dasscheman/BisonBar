<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tally extends Model
{
    use HasFactory, SoftDeletes;

    const TYPE_tally_list = 1;

    const TYPE_tally = 2;

    const TYPE_round = 3;

    const TYPE_direct_payment = 4;

    protected $table = 'la_tally';

    protected $fillable = [
        'id',
        'tally_list_id',
        'assortment_id',
        'user_id',
        'count',
        'price',
        'type_id',
        'status_id',
        'invoice_id',
        'payment_id',
        'created_at',
        'updated_at',
    ];

    public function assortment(): BelongsTo
    {
        return $this->belongsTo(Assortment::class);
    }

    public function tallyList(): BelongsTo
    {
        return $this->belongsTo(TallyList::class);
    }
}
