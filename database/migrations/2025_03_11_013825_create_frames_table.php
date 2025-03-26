<?php

use App\Models\Frame;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('frames', function (Blueprint $table) {
            $table->id();
            $table->string('name', 60)->unique();
            $table->decimal('price');
            $table->string('static_src', 255);
            $table->string('animated_src', 255);
            $table->unsignedBigInteger('valid_duration')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->timestamps();
        });

        Frame::create([
            'name' => 'Default',
            'price' => 0,
            'static_src' => 'ladies-frame.webp',
            'animated_src' => 'ladies-frame',
            'status' => 1,
        ]);

        Frame::create([
            'name' => 'Test With Expiry',
            'price' => 150,
            'static_src' => 'default-frame.webp',
            'animated_src' => '1',
            'status' => 1,
            'valid_duration' => '985016'
        ]);

        Frame::create([
            'name' => 'Test Without Expiry',
            'price' => 0,
            'static_src' => '1.webp',
            'animated_src' => '2',
            'status' => 2,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('frames');
    }
};
