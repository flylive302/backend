<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Room;
use App\Models\Reward;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Theme extends Model
{
    /** @use HasFactory<\Database\Factories\ThemeFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'theme_color',
        'icon_color',
        'thumbnail_src',
        'background_src',
        'seat_ring_src',
        'seat_src',
        'space_btw_ring_and_seat',
        'status',
        'price',
        'valid_duration_seconds',
    ];

    protected $casts = [
        'price' => 'float',
        'valid_duration_seconds' => 'integer',
        'space_btw_ring_and_seat' => 'integer',
        'status' => 'integer',
    ];

    /**
     * Has many rooms
     */
    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
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
     * Belongs to many users (pivot)
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot([
                'purchased_at',
                'expires_at',
                'quantity',
            ])
            ->withTimestamps();
    }
}
