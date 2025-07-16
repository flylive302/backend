<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Gift extends Model
{
    /** @use HasFactory<\Database\Factories\GiftFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category',
        'name',
        'price',
        'static_src',
        'animated_file_type',
        'animated_src',
        'animation_duration',
    ];

    protected $casts = [
        'price' => 'float',
        'animation_duration' => 'integer',
        'category' => 'integer',
    ];

    /**
     * Morph many transactions (transactionable)
     */
    public function transactions(): MorphMany
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }
}
