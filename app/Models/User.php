<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'email',
        'phone',
        'password',
        'signature',
        'dob',
        'gender',
        'country',
        'remember_token',
        'is_blocked',
        'social_provider',
        'social_provider_id',
        'blocked_at',
        'block_reason',
        'seat_id',
        'frame_id',
        'deleted_at',
        'name',
        'avatar_url'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Automatically convert gender string to tinyInt when setting it.
     */
    public function setGenderAttribute($value): void
    {
        $genderMap = [
            'male' => 1,
            'female' => 2,
            'others' => 3,
        ];

        $this->attributes['gender'] = $genderMap[strtolower($value)] ?? null;
    }

    /**
     * Automatically convert gender tinyInt back to string when getting it.
     */
    public function getGenderAttribute($value): string
    {
        $reverseGenderMap = [
            1 => 'male',
            2 => 'female',
            3 => 'others',
        ];

        return $reverseGenderMap[$value] ?? 'unknown';
    }

    /**
     * Mutator: Convert `dob` to `Y-m-d` before saving to database.
     */
    public function setDobAttribute($value)
    {
        $this->attributes['dob'] = $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function frames()
    {
        return $this->belongsToMany(Frame::class)->withPivot(
            'rented_at',
            'expires_at',
            'quantity',
            'is_active'
        );
    }
}
