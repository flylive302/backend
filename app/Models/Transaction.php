<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
    use HasFactory;
    use softDeletes;

    protected $fillable = [
        'quantity',
        'real_value',
        'change_in_value',
        'currency_type',
        'before',
        'after',
        'status',
        'user_id',
        'beneficiary_id',
        'transactionable_id',
        'transactionable_type',
        'deleted_at',
    ];

    public function setCurrencyAttribute($value): void
    {
        $currencyMap = [
            'coin_balance' => 1,
            'diamond_balance' => 2,
        ];

        $this->attributes['currency'] = $currencyMap[strtolower($value)] ?? null;
    }

    /**
     * Automatically convert currency tinyInt back to string when getting it.
     */
    public function getCurrencyAttribute($value): string
    {
        $reverseCurrencyMap = [
            1 => 'coin_balance',
            2 => 'diamond_balance',
        ];

        return $reverseCurrencyMap[$value] ?? 'unknown';
    }

    public function initiator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function beneficiary(): BelongsTo
    {
        return $this->belongsTo(User::class, 'beneficiary_id');
    }

    public function transactionable(): MorphTo
    {
        return $this->morphTo();
    }
}
