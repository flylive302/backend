<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Seat extends Model
{
    /** @use HasFactory<\Database\Factories\SeatFactory> */
    use HasFactory;

    protected $fillable = [
        'room_id',
        'user_id',
        'status',
        'is_muted',
    ];

    protected $casts = [
        'room_id' => 'integer',
        'user_id' => 'integer',
        'status' => 'integer',
        'is_muted' => 'boolean',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
