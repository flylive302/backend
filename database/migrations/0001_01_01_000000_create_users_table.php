<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('signature', 50)->nullable()->unique();
            $table->string('phone', 20)->nullable()->unique();
            $table->string('email', 255)->nullable()->unique();
            $table->char('country', 2)->nullable()->index();
            $table->string('name', 100)->nullable()->index();
            $table->tinyInteger('gender')->unsigned()->nullable();
            $table->date('dob')->nullable();
            $table->string('password', 255)->nullable();
            $table->text('avatar_image')->nullable();
            $table->boolean('is_blocked')->nullable();
            $table->timestamp('blocked_at')->nullable();
            $table->string('block_reason', 255)->nullable();
            $table->string('social_provider', 50)->nullable();
            $table->string('social_provider_id', 255)->nullable();
            $table->decimal('coin_balance')->nullable()->default(0);
            $table->decimal('diamond_balance')->nullable()->default(0);
            $table->decimal('wealth_xp')->nullable()->default(0);
            $table->decimal('charm_xp')->nullable()->default(0);
            $table->decimal('room_xp')->nullable()->default(0);
            $table->timestamp('deleted_at')->nullable();
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
