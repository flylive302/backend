<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Level;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reward extends Model
{
    /** @use HasFactory<\Database\Factories\RewardFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'rewardable_id',
        'rewardable_type',
        'level_id',
        'name',
        'type',
        'value',
        'valid_duration_seconds',
    ];

    protected $casts = [
        'value' => 'float',
        'valid_duration_seconds' => 'integer',
        'type' => 'integer',
        'level_id' => 'integer',
    ];

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }
}
