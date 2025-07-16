<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Visitor extends Model
{
    protected $table = 'visitors';

    protected $fillable = [
        'room_id',
        'user_id',
        'is_banned',
        'kicked_at',
        'kicked_for',
        'joined_at',
        'left_at',
    ];

    protected $casts = [
        'room_id' => 'integer',
        'user_id' => 'integer',
        'is_banned' => 'boolean',
        'kicked_at' => 'string',
        'kicked_for' => 'string',
        'joined_at' => 'datetime',
        'left_at' => 'datetime',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
} 