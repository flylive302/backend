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
        Schema::create('gifts', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('category')->index();
            $table->string('name', 100);
            $table->decimal('price', 8, 2);
            $table->string('static_src', 255);
            $table->char('animated_file_type', 30);
            $table->string('animated_src', 255);
            $table->unsignedInteger('animation_duration');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gifts');
    }
};
