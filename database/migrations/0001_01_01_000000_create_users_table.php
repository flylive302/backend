<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->index();
            $table->string('signature', 50)->unique();
            $table->string('phone', 20)->nullable()->unique();
            $table->string('email', 255)->unique();
            $table->char('country', 2)->nullable()->index();
            $table->unsignedTinyInteger('gender')->nullable();
            $table->date('dob')->nullable();
            $table->string('password', 255);
            $table->string('avatar_image')->nullable();
            $table->boolean('is_blocked')->default(false);
            $table->timestamp('blocked_at')->nullable();
            $table->string('block_reason', 255)->nullable();
            $table->string('social_provider', 50)->nullable();
            $table->string('social_provider_id', 255)->nullable();
            $table->decimal('coin_balance', 16, 4)->default(0);
            $table->decimal('diamond_balance', 16, 4)->default(0);
            $table->decimal('wealth_xp', 16, 4)->default(0);
            $table->decimal('charm_xp', 16, 4)->default(0);
            $table->decimal('room_xp', 16, 4)->default(0);
            $table->softDeletes('deleted_at', 0);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        User::create([
            'name' => 'Admin user',
            'phone' => '+923005274302',
            'email' => 'admin@flylive.com',
            'gender' => 'male',
            'dob' => '1999-01-01',
            'country' => 'pk',
            'password' => Hash::make('admin@flylive.com'),
            'signature' => '@admin',
            'coin_balance' => 10000
        ]);

        User::create([
            'name' => 'Reseller user',
            'phone' => '+923005274303',
            'email' => 'reseller@flylive.com',
            'gender' => 'male',
            'dob' => '1999-01-01',
            'country' => 'pk',
            'password' => Hash::make('reseller@flylive.com'),
            'signature' => '@reseller',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
