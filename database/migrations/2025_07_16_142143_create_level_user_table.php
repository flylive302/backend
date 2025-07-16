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
        Schema::create('level_user', function (Blueprint $table) {
            $table->unsignedBigInteger('level_id');
            $table->unsignedBigInteger('user_id');
            $table->boolean('is_active')->default(false);
            $table->unsignedTinyInteger('type');
            $table->decimal('points_before', 8, 2);
            $table->decimal('points_after', 8, 2);
            $table->timestamp('achieved_at')->nullable();
            $table->timestamp('lost_at')->nullable();
            $table->softDeletes();
            $table->primary(['level_id', 'user_id']);
            $table->foreign('level_id')->references('id')->on('levels')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('level_user');
    }
};
