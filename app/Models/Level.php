<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Reward;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Level extends Model
{
    /** @use HasFactory<\\Database\\Factories\\LevelFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'type',
        'description',
        'min_points',
        'max_points',
        'badge',
    ];

    protected $casts = [
        'min_points' => 'float',
        'max_points' => 'float',
        'type' => 'integer',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot([
                'is_active',
                'type',
                'points_before',
                'points_after',
                'achieved_at',
                'lost_at',
                'deleted_at',
            ])
            ->withTimestamps();
    }

    public function rewards(): HasMany
    {
        return $this->hasMany(Reward::class);
    }
}
