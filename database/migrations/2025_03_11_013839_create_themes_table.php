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
        Schema::create('themes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->char('theme_color', 30);
            $table->char('icon_color', 30);
            $table->string('thumbnail_src', 255);
            $table->string('background_src', 255);
            $table->string('seat_ring_src', 255);
            $table->string('seat_src', 255);
            $table->tinyInteger('space_btw_ring_and_seat')->nullable();
            $table->unsignedTinyInteger('status');
            $table->decimal('price', 8, 2);
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
        Schema::dropIfExists('themes');
    }
};
