<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Assortment extends Model
{
    use HasFactory, SoftDeletes;

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
}
