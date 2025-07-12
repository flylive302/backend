<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot(
            'expires_at',
            'quantity',
            'is_active'
        )->withTimestamps();
    }
}
