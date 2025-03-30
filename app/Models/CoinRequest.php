<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(mixed $validated)
 */
class CoinRequest extends Model
{

    protected $fillable = [
        'amount',
        'message',
        'action_message',
        'proof_1',
        'proof_2',
        'proof_3',
        'type',
        'status',
        'credit_days',
        'user_id',
        'requested_from',
        'updated_by',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->select([
            'id', 'name', 'signature', 'avatar_image', 'coin_balance'
        ]);
    }

    public function requestedFrom(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_from')->select([
            'id', 'name', 'signature', 'avatar_image', 'coin_balance'
        ]);
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    protected function casts(): array
    {
        return [
            'amount' => 'float',
        ];
    }
}
