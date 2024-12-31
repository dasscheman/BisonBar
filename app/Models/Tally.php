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

    public function invoice()
    {
        return $this->belongsTo(Invoices::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function status()
    {
        return Status::getStatusOptions()[$this->status_id];
    }

    public function tallyList(): BelongsTo
    {
        return $this->belongsTo(TallyList::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTypeOptions()
    {
        return [
            self::TYPE_tally_list => __('TYPE_tally_list'),
            self::TYPE_tally => __('TYPE_tally'),
            self::TYPE_round => __('TYPE_round'),
            self::TYPE_direct_payment => __('TYPE_direct_payment'),
        ];
    }

    public function type()
    {
        return $this->getTypeOptions()[$this->type_id];
    }
}
