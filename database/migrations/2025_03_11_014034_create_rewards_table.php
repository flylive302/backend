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
        Schema::create('rewards', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('rewardable_id')->index();
            $table->string('rewardable_type', 255);
            $table->unsignedBigInteger('level_id')->index();
            $table->string('name', 100);
            $table->tinyInteger('type');
            $table->decimal('value', 8, 2);
            $table->unsignedBigInteger('valid_duration_seconds');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rewards');
    }
};
