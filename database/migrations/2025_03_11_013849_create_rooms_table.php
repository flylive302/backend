<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('popularity_index')->default(0)->index();
            $table->char('country', 2)->index();
            $table->string('name', 100)->unique();
            $table->text('greetings')->nullable();
            $table->string('logo')->nullable();
            $table->boolean('can_tourists_speak')->default(true);
            $table->boolean('can_tourists_send_text')->default(true);
            $table->boolean('can_tourists_send_files')->default(true);
            $table->boolean('is_hidden')->default(false)->index();
            $table->string('password')->nullable();
            $table->tinyInteger('type')->default(1);
            $table->timestamp('created_at')->useCurrent()->index();
            $table->timestamp('updated_at');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
