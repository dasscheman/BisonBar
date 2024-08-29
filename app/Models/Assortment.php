<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Assortment extends Model
{
    use HasFactory, SoftDeletes;

    const CATEGORY_soda = 1;
    const CATEGORY_beer = 2;
    const CATEGORY_wine = 3;
    const CATEGORY_snack = 4;
    const CATEGORY_other = 5;

    const STATUS_available = 1;
    const STATUS_not_available = 2;
    const STATUS_temporally_not_available = 3;

    protected $table = 'la_assortments';

    protected $fillable = [
        'id',
        'name',
        'price',
        'category_id',
        'status_id',
        'created_at',
        'updated_at',
    ];

    public function tallies(): HasMany
    {
        return $this->hasMany(Tally::class);
    }

    public function getCategoryOptions()
    {
        return [
            self::CATEGORY_soda => __('Soda'),
            self::CATEGORY_beer => __('Beer'),
            self::CATEGORY_wine => __('Wine'),
            self::CATEGORY_snack => __('Snacks'),
            self::CATEGORY_other => __('Other'),
        ];
    }

    public function category()
    {
        return $this->getCategoryOptions()[$this->category_id];
    }

    public function getStatusOptions()
    {
        return [
            self::STATUS_available => __('Available'),
            self::STATUS_not_available => __('Not Available'),
            self::STATUS_temporally_not_available => __('Temporally Not Available')
        ];
    }

    public function status()
    {
        return $this->getStatusOptions()[$this->status_id];
    }

    public function totalSold()
    {
        return $this->tallies()
            ->where('status_id', Status::STATUS_factuur_verzonden)
            ->sum('price');
    }
}
