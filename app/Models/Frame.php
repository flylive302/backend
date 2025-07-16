<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Reward;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Frame extends Model
{
    /** @use HasFactory<\Database\Factories\FrameFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'static_src',
        'animated_src',
        'valid_duration',
        'status',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    /**
     * Many-to-many users (pivot)
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot(
            'expires_at',
            'quantity',
            'is_active'
        )->withTimestamps();
    }

    /**
     * Morph many rewards (rewardable)
     */
    public function rewards(): MorphMany
    {
        return $this->morphMany(Reward::class, 'rewardable');
    }

    /**
     * Morph many transactions (transactionable)
     */
    public function transactions(): MorphMany
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }

    /**
     * Has many users (direct, not pivot)
     */
    public function directUsers(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Belongs to a user (owner)
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
