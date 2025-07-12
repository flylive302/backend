<?php

namespace App\Models;

use Database\Factories\RoomFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    /** @use HasFactory<RoomFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'popularity_index',
        'country',
        'name',
        'greetings',
        'logo',
        'can_tourists_speak',
        'can_tourists_send_text',
        'can_tourists_send_files',
        'is_hidden',
        'password',
        'type'
    ];

    protected $hidden = ['password'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->select([
            'id', 'name', 'signature', 'avatar_image', 'coin_balance'
        ]);
    }

    public function seats(): HasMany|Room
    {
        return $this->hasMany(Seat::class);
    }

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}
