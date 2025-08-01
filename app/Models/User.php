<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Level;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Seat;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Visitor;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Message;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
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
        'avatar_image',
        'animated_src',
        'static_src',
        'coin_balance',
        'diamond_balance'
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
    public function setDobAttribute($value): void
    {
        $this->attributes['dob'] = $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function frames()
    {
        return $this->belongsToMany(Frame::class)->withPivot(
            'expires_at',
            'quantity',
            'is_active'
        )->withTimestamps();
    }

    public function initiatedTransactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'user_id');
    }

    public function receivedTransactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'beneficiary_id');
    }

    public function coinRequests()
    {
        return $this->hasMany(CoinRequest::class, 'user_id');
    }

    public function coinRequestedFromMe()
    {
        return $this->hasMany(CoinRequest::class, 'requested_from');
    }

    public function room()
    {
        return $this->hasOne(Room::class);
    }

    public function levels(): BelongsToMany
    {
        return $this->belongsToMany(Level::class)
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

    public function seat(): BelongsTo
    {
        return $this->belongsTo(Seat::class);
    }

    public function visitor(): HasOne
    {
        return $this->hasOne(Visitor::class);
    }

    /**
     * Messages sent by this user.
     */
    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * Messages received by this user.
     */
    public function receivedMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

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
            'dob' => 'datetime:Y-m-d',
            'gender' => 'integer',
            'created_at' => 'datetime:Y-m-d',
            'updated_at' => 'datetime:Y-m-d',
            'deleted_at' => 'datetime:Y-m-d',
            'blocked_at' => 'datetime:Y-m-d',
            'seat_id' => 'integer',
            'frame_id' => 'integer',
            'social_provider_id' => 'integer',
            'coin_balance' => 'float',
            'diamond_balance' => 'float',
        ];
    }
}
